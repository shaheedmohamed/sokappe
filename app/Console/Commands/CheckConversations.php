<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Conversation;

class CheckConversations extends Command
{
    protected $signature = 'check:conversations';
    protected $description = 'Check conversations data';

    public function handle()
    {
        $conversations = Conversation::with(['client', 'freelancer'])->get();
        
        $this->info('Total conversations: ' . $conversations->count());
        
        foreach ($conversations as $conversation) {
            $this->line('ID: ' . $conversation->id);
            $this->line('Client ID: ' . $conversation->client_id . ' - Name: ' . ($conversation->client ? $conversation->client->name : 'NULL'));
            $this->line('Freelancer ID: ' . $conversation->freelancer_id . ' - Name: ' . ($conversation->freelancer ? $conversation->freelancer->name : 'NULL'));
            $this->line('---');
        }
    }
}
