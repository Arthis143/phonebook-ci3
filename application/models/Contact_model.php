<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Contact_model
 *
 * Handles all database operations for the `contacts` table.
 *
 * @package   Phonebook
 */
class Contact_model extends CI_Model
{
    /**
     * @var string  Name of the database table
     */
    protected $table = 'contacts';

    /**
     * Constructor
     *
     * Ensures the database library is loaded.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all contacts, ordered newest first.
     *
     * @return array  List of contact objects
     */
    public function get_all()
    {
        return $this->db
            ->order_by('id', 'DESC')
            ->get($this->table)
            ->result();
    }

    /**
     * Get a single contact by its ID.
     *
     * @param  int  $id  Contact ID
     * @return object|null  Contact object or null if not found
     */
    public function get($id)
    {
        return $this->db
            ->where('id', $id)
            ->get($this->table)
            ->row();
    }

    /**
     * Insert a new contact record.
     *
     * @param  array  $data  ['name'=>..., 'phone'=>..., 'status'=>..., 'region'=>...]
     * @return bool
     */
    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    /**
     * Update an existing contact.
     *
     * @param  int    $id    Contact ID to update
     * @param  array  $data  Column=>value pairs
     * @return bool
     */
    public function update($id, $data)
    {
        return $this->db
            ->where('id', $id)
            ->update($this->table, $data);
    }

    /**
     * Delete a contact by its ID.
     *
     * @param  int  $id  Contact ID to delete
     * @return bool
     */
    public function delete($id)
    {
        return $this->db
            ->where('id', $id)
            ->delete($this->table);
    }

    /**
     * Delete multiple contacts by an array of IDs.
     *
     * @param  array  $ids  Contact IDs to delete
     * @return bool
     */
    public function delete_many($ids)
    {
        if (empty($ids)) {
            return FALSE;
        }

        return $this->db
            ->where_in('id', $ids)
            ->delete($this->table);
    }

    /**
     * Get the table name (for dynamic queries).
     *
     * @return string
     */
    public function get_table_name()
    {
        return $this->table;
    }
}
