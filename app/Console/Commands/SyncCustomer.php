<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\CustomerDetail;
use Webpatser\Uuid\Uuid;

class SyncCustomer extends Command
{
    /**e
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sync_cus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $this->sync_customer();
    }

    protected function sync_customer()
    {
        $customer = DB::table('Projects')->get();
        foreach($customer as $val)
        {
            $customer = new Customer();
            $customer->name = $val->name;
            $customer->path = $val->path;
            $customer->uuid = Uuid::generate();
            $customer->save();
        }
        $customer_details = DB::table('customers')
            ->join('projects2workflow','customers.name','=','projects2workflow.project_name')
            ->select('customers.uuid','projects2workflow.*')
            ->get();

        print_r($customer_details);

        foreach($customer_details as $val) {
            $customer_details = new CustomerDetail();
            $customer_details->customer_uuid = $val->uuid;
            $customer_details->customer_name = $val->project_name;
            $customer_details->path = $val->path;
            $customer_details->workflow_path = $val->workflow_path;
            $customer_details->assemblyInfo_path = $val->assemblyInfo_path;
            $customer_details->assemblyInfo = $val->assemblyInfo;
            $customer_details->assemblyFileInfo = $val->assemblyFileInfo;
            $customer_details->workflow_version = $val->workflow_version;
            $customer_details->erp_version = $val->erp_version;
            $customer_details->save();
//        print_r($customer);
        }

    }
}
