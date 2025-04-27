<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard Controller
 *
 * Displays summary statistics and the latest contacts for the Phonebook system.
 *
 * @property Contact_model $contact_model  Instance of Contact_model
 */
class Dashboard extends CI_Controller
{
    /**
     * Constructor
     *
     * Loads required models and helpers.
     */
    public function __construct()
    {
        parent::__construct();

        // Load the Contact_model and assign it to $this->contact_model
        $this->load->model('Contact_model', 'contact_model');

        // Load URL helper for functions like site_url(), base_url(), etc.
        $this->load->helper('url');
    }

    /**
     * Default method for the Dashboard
     *
     * - Fetches all contacts
     * - Calculates total, active, and inactive counts
     * - Retrieves the five most recent contacts
     * - Passes data to the dashboard view
     */
    public function index()
    {
        // 1) Retrieve all contacts from the database
        $allContacts = $this->contact_model->get_all();

        // 2) Compute summary statistics
        $totalContacts    = count($allContacts);
        $activeContacts   = count(array_filter($allContacts, function ($contact) {
            return $contact->status === 'active';
        }));
        $inactiveContacts = $totalContacts - $activeContacts;

        // 3) Get the five most recent entries (assuming get_all() returns newest first)
        $recentContacts = array_slice($allContacts, 0, 5);

        // 4) Prepare data array for the view
        $viewData = [
            'total'         => $totalContacts,
            'activeCount'   => $activeContacts,
            'inactiveCount' => $inactiveContacts,
            'latest'        => $recentContacts,
        ];

        // 5) Render the page
        $this->load->view('templates/header', ['title' => 'Dashboard']);
        $this->load->view('dashboard/index', $viewData);
        $this->load->view('templates/footer');
    }
}
