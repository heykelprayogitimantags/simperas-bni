<?php

namespace App\Models;

use CodeIgniter\Model;

class TicketModel extends Model
{
    protected $table            = 'tickets';
    protected $primaryKey       = 'ticket_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'ticket_number',
        'asset_id',
        'reported_by',
        'title',
        'description',
        'priority',
        'status'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'asset_id'    => 'required|numeric',
        'title'       => 'required|min_length[5]',
        'description' => 'required|min_length[10]',
        'priority'    => 'required|in_list[low,medium,high]',
    ];

    protected $validationMessages = [
        'asset_id' => [
            'required' => 'Asset harus dipilih',
        ],
        'title' => [
            'required'   => 'Judul tiket harus diisi',
            'min_length' => 'Judul minimal 5 karakter',
        ],
        'description' => [
            'required'   => 'Deskripsi masalah harus diisi',
            'min_length' => 'Deskripsi minimal 10 karakter',
        ],
    ];

    /**
     * Generate ticket number
     */
    public function generateTicketNumber()
    {
        $year = date('Y');
        $month = date('m');
        
        // Get last ticket
        $lastTicket = $this->like('ticket_number', 'TKT-' . $year . $month)
                           ->orderBy('ticket_id', 'DESC')
                           ->first();
        
        if ($lastTicket) {
            $lastNumber = (int) substr($lastTicket['ticket_number'], -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return 'TKT-' . $year . $month . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get recent tickets with relations
     */
    public function getRecentTickets($limit = 10)
    {
        return $this->select('tickets.*, assets.asset_name, assets.asset_code, users.full_name as reporter_name')
                    ->join('assets', 'assets.asset_id = tickets.asset_id')
                    ->join('users', 'users.user_id = tickets.reported_by')
                    ->orderBy('tickets.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get my tickets (for pegawai)
     */
    public function getMyTickets($userId, $limit = 10)
    {
        return $this->select('tickets.*, assets.asset_name, assets.asset_code')
                    ->join('assets', 'assets.asset_id = tickets.asset_id')
                    ->where('tickets.reported_by', $userId)
                    ->orderBy('tickets.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get tickets for technician to work on
     */
    public function getTicketsForTechnician($limit = 10)
    {
        return $this->select('tickets.*, assets.asset_name, assets.asset_code, users.full_name as reporter_name')
                    ->join('assets', 'assets.asset_id = tickets.asset_id')
                    ->join('users', 'users.user_id = tickets.reported_by')
                    ->whereIn('tickets.status', ['pending', 'in_progress'])
                    ->orderBy('tickets.priority', 'DESC')
                    ->orderBy('tickets.created_at', 'ASC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get ticket detail with all relations
     */
    public function getTicketDetail($ticketId)
    {
        return $this->select('tickets.*, assets.asset_name, assets.asset_code, assets.asset_type, users.full_name as reporter_name, users.department')
                    ->join('assets', 'assets.asset_id = tickets.asset_id')
                    ->join('users', 'users.user_id = tickets.reported_by')
                    ->where('tickets.ticket_id', $ticketId)
                    ->first();
    }

    /**
     * Get tickets by status
     */
    public function getTicketsByStatus($status)
    {
        return $this->select('tickets.*, assets.asset_name, users.full_name as reporter_name')
                    ->join('assets', 'assets.asset_id = tickets.asset_id')
                    ->join('users', 'users.user_id = tickets.reported_by')
                    ->where('tickets.status', $status)
                    ->orderBy('tickets.created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get tickets by priority
     */
    public function getTicketsByPriority($priority)
    {
        return $this->where('priority', $priority)->findAll();
    }

    /**
     * Update ticket status
     */
    public function updateTicketStatus($ticketId, $status)
    {
        return $this->update($ticketId, ['status' => $status]);
    }
}