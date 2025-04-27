<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Contacts Controller
 *
 * Manages CRUD operations, bulk deletion, and search/sort for contacts.
 *
 * @property Contact_model         $contact_model    Instance of Contact_model
 * @property CI_Form_validation    $form_validation  Form Validation library
 * @property CI_DB_query_builder   $db               Database query builder
 * @property CI_Input              $input            Input library
 * @property CI_Loader             $load             Loader class
 */
class Contacts extends CI_Controller
{
    /**
     * Constructor
     *
     * Loads model, libraries, helpers, and database.
     */
    public function __construct()
    {
        parent::__construct();

        // Load the Contact_model and assign to $this->contact_model
        $this->load->model('Contact_model', 'contact_model');

        // Load form validation library
        $this->load->library('form_validation');

        // Load URL helper (for site_url(), base_url(), etc.)
        $this->load->helper('url');

        // Ensure database is loaded
        $this->load->database();
    }

    /**
     * List all contacts with optional search & sort
     *
     * URL parameters (GET):
     *  - column: name | phone | status | region
     *  - value:  search term
     *  - sort:   latest | earliest | name
     *  - dir:    asc | desc
     */
    public function index()
    {
        // 1) Retrieve query parameters
        $column = $this->input->get('column') ?? '';
        $value  = $this->input->get('value')  ?? '';
        $sort   = $this->input->get('sort')   ?? 'latest';
        $dir    = $this->input->get('dir')    ?? 'desc';

        // 2) Begin query on contacts table
        $this->db->from($this->contact_model->get_table_name());

        // 3) Apply search filter if valid column + non-empty value
        $allowedCols = ['name','phone','status','region'];
        if ($column === 'region' && is_array($value) && !empty($value)) {
            $this->db->where_in('region', $value);
        }
        elseif ($column === 'status' && $value !== '') {
            $this->db->where('status', $value);
        }
        elseif (in_array($column, ['name','phone'], TRUE) && $value !== '') {
            // Ensure $value is a string
            if (is_array($value)) {
                $value = reset($value);
            }
            $this->db->like($column, $value);
        }

        // 4) Apply sorting
        if ($sort === 'name' && in_array($dir, ['asc','desc'], TRUE)) {
            $this->db->order_by('name', $dir);
        } elseif ($sort === 'earliest') {
            $this->db->order_by('id', 'asc');
        } else {
            // default to newest first
            $this->db->order_by('id', 'desc');
        }

        // 5) Execute query and gather results
        $contacts = $this->db->get()->result();

        // 6) Package data for the view, preserving filter/sort state
        $data = [
            'contacts' => $contacts,
            'column'   => $column,
            'value'    => $value,
            'sort'     => $sort,
            'dir'      => $dir,
        ];

        // 7) Render views
        $this->load->view('templates/header', ['title' => 'Contacts']);
        $this->load->view('contacts/index', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Display the create form, or process create submission
     */
    public function create()
    {
        // 1) Define form rules
        $this->form_validation->set_rules('name',   'Name',   'trim|required');
        $this->form_validation->set_rules('phone',  'Phone',  'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_rules('region', 'Region', 'required');

        // 2) If validation fails or first load, show the form
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', ['title' => 'Add Contact']);
            $this->load->view('contacts/form');
            $this->load->view('templates/footer');
            return;
        }

        // 3) Validation passed – insert the new contact
        $this->contact_model->insert([
            'name'   => $this->input->post('name'),
            'phone'  => $this->input->post('phone'),
            'status' => $this->input->post('status'),
            'region' => $this->input->post('region'),
        ]);

        // 4) Redirect back to the list
        redirect('contacts');
    }

    /**
     * Display the edit form, or process update submission
     *
     * @param  int  $id  Contact ID to edit
     */
    public function edit($id)
    {
        // 1) Load existing contact or show 404
        $contact = $this->contact_model->get($id) or show_404();

        // 2) Define form rules (same as create)
        $this->form_validation->set_rules('name',   'Name',   'trim|required');
        $this->form_validation->set_rules('phone',  'Phone',  'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_rules('region', 'Region', 'required');

        // 3) If validation fails or first load, show the form with data
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', ['title' => 'Edit Contact']);
            $this->load->view('contacts/form', ['contact' => $contact]);
            $this->load->view('templates/footer');
            return;
        }

        // 4) Validation passed – update the contact
        $this->contact_model->update($id, [
            'name'   => $this->input->post('name'),
            'phone'  => $this->input->post('phone'),
            'status' => $this->input->post('status'),
            'region' => $this->input->post('region'),
        ]);

        // 5) Redirect back to the list
        redirect('contacts');
    }

    /**
     * Delete a single contact by ID
     *
     * @param  int  $id  Contact ID to delete
     */
    public function delete($id)
    {
        $this->contact_model->delete($id);
        redirect('contacts');
    }

    /**
     * Bulk delete selected contacts
     */
    public function bulk_delete()
    {
        // 1) Get array of IDs from the POSTed 'selected[]' checkboxes
        $ids = $this->input->post('selected');

        // 2) If valid, delete them
        if (! empty($ids) && is_array($ids)) {
            $this->contact_model->delete_many($ids);
        }

        // 3) Return to the list
        redirect('contacts');
    }
}
