<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Approval;
use App\Models\User;
use App\Models\Clicks;
use App\Models\Reports;
use App\Models\Feedback;
use App\Models\Contacts;
use App\Models\ReplyUser;
use DB;
use Carbon;


use App\Mail\SendMail;

use Mail;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $approval =Approval::where('Status', false);
        $approval = DB::table('approvals')->where('Status', false)->paginate(15);     

        return view('admin.index')->with('approval', $approval);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function replyuser($id, $userid)
    {
        $name = DB::table('users')->where('id', $userid)->get();
        // $userdata = DB::table('users')->where('id', $id)->get();
        $msg = Contacts::where('Status', false)->where('UserId', $userid)->get();


        return view('admin.replyuser')->with('name', $name)->with('msg', $msg);
    }

    public function replyuserform(Request $request)
    {
        $this->validate($request,[
            'message' => 'required',
            'subject' => 'required',           

        ]);
        $idx =  $request->input('msgid');
        $data1 = Contacts::where('id', $idx)->value('Subject');

        $sendm = new ReplyUser;

        $sendm->Subject = $request->input('subject');
        $sendm->In_reply_to = $data1;
        $sendm->Message = $request->input('message');
        $sendm->UserId = $request->input('userid');

        $sendm->save();

        return back()->with('success', 'message sent !');

        
        
    }
    
     public function readfeedback($id)
    {
         DB::table('feedback')->where('id', $id)->update(['Status' => true]);
         
         return redirect()->back()->with('success', 'Submitted successfully!');


    }

    public function allusers()
    {
        //

        $allusers = User::orderBy('id', 'DESC')->paginate(20);
        $countusers = User::count();
        $countusersa = User::where('Approved', true)->count();
        $countusersi = User::where('Approved', false)->count();

        return view('admin.allusers')->with('allusers', $allusers)->with('countusers', $countusers)->with('countusersa', $countusersa)->with('countusersi', $countusersi);
    }

    public function inactiveusers()
    {
        //

        $allusers = User::where('Approved', false)->orderBy('id', 'DESC')->paginate(20);
        $countusers = User::where('Approved', false)->count();
        return view('admin.inactiveusers')->with('allusers', $allusers)->with('countusers', $countusers);
    }

    public function activeusers()
    {
        //

        $allusers = User::where('Approved', true)->orderBy('id', 'DESC')->paginate(20);
        $countusers = User::where('Approved', true)->count();
        return view('admin.activeusers')->with('allusers', $allusers)->with('countusers', $countusers);
    }

    public function reportedusers()
    {
        //

        $allreports = Reports::where('Status', false)->orderBy('id', 'DESC')->paginate(20);


        $countreports = Reports::count();
       
        return view('admin.reportedusers')
        ->with('allreports', $allreports)
        ->with('countreports', $countreports);
        
    }

    public function approvalrequests()
    {
        //

        $allreports = Approval::where('Status', false)->orderBy('id', 'ASC')->paginate(20);


        $countreports = Approval::where('Status', false)->count();
       
        return view('admin.approvalrequests')
        ->with('allreports', $allreports)
        ->with('countreports', $countreports);
        
    }
    public function suspendreportedusers($id,$reportedid)
    {
        $date = Carbon\Carbon::now();
        $block = date('Y-m-d', strtotime('+7 days', strtotime($date))); 


        DB::table('users')->where('id', $reportedid);  (['banned' => true]);
        DB::table('users')->where('id', $reportedid)->update(['blocked_until' => $block]);
        DB::table('reports')->where('id', $id)->update(['Status' => true]);

        $mail = User::where('id', $reportedid)->get();

        $data = array(
                
            'name'      =>  'ClickNet Member',
            'subject'   =>  'Clicknet Report',
            // 'email'  =>  $request->email,
            'message'   =>   'You have been reported by a ClickNet Member for violating
                                their rules.After reviewing the report, we found that you have
                                violated their rules, your account will be suspended for 7 days.
                                Regards ClickNet Team.
            '
        );

        // $mail = $request->input('email');
        
            Mail::to($mail)->send(new SendMail($data));

        return back()->with('error', 'User banned !');



    }

    public function banreportedusers($id,$reportedid)
    {
        $date = Carbon\Carbon::now();
        $block = date('Y-m-d', strtotime('+14 days', strtotime($date))); 



        DB::table('users')->where('id', $reportedid);  (['banned' => true]);
        DB::table('users')->where('id', $reportedid)->update(['blocked_until' => $block]);
        DB::table('reports')->where('id', $id)->update(['Status' => true]);

        $mail = User::where('id', $reportedid)->get();

        $data = array(
                
            'name'      =>  'ClickNet Member',
            'subject'   =>  'Clicknet Report',
            // 'email'  =>  $request->email,
            'message'   =>   'You have been reported by a ClickNet Member for violating
                                their rules.After reviewing the report, we found that you have
                                violated their rules, your account will be suspended for 14 days.
                                Regards ClickNet Team.
            '
        );

        // $mail = $request->input('email');
        
            Mail::to($mail)->send(new SendMail($data));

        

        return back()->with('error', 'User banned !');



    }

    public function ignorereportedusers($id,$reportedid)
    {
        DB::table('reports')->where('id', $id)->update(['Status' => 2]);

        return back()->with('success', 'User saved !');
    }

    public function feedbacks()
    {
        $feed = Feedback::where('Status', false)->orderBy('id', 'DESC')->paginate(20);
        return view('admin.feedbacks')->with('feed', $feed);
    }

    public function usermessages()
    {
        $feed = Contacts::where('Status', false)->orderBy('id', 'DESC')->paginate(20);
        return view('admin.messages')->with('feed', $feed);
    }
     public function readusermessages($id)
    {
       DB::table('contacts')->where('id', $id)->update(['Status' => true]);

        return back()->with('success', 'Complete !!');
    }


    public function approveuser($id, $userid)
    {
        DB::table('users')->where('id', $userid)->update(['Approved' => true]);

        DB::table('approvals')->where('id', $id)->update(['Status' => true]);

        $date = Carbon\Carbon::now();
        $str2 = date('Y-m-d', strtotime('+7 days', strtotime($date))); 
      
        DB::table('users')->where('id', $userid)->update(['login_expiry' => $str2]);

        
        $names = User::all();
        $username = User::where('id', $userid)->value('name');
        $mail = User::where('id', $userid)->get();

        $data = array(
                
            'name'      =>  'ClickNet Member',
            'subject'   =>  'Clicknet Application Status',
            // 'email'  =>  $request->email,
            'message'   =>   'Congratulations, your request to join Clicknet has been approved.
           Proceed to add your site to Clicknet and make sure to read our Rules.
            Happy Time at Clicknet.
            '
        );

        // $mail = $request->input('email');
        
            Mail::to($mail)->send(new SendMail($data));

        return redirect()->back()->with('success', 'Approved successfully!, Email sent success');

        ///send user email approval

      
        
         


    }

    public function denyapproveuser($id, $userid)
    {

        DB::table('approvals')->where('id', $id)->update(['Status' => 3]);
        
                DB::table('users')->where('id', $userid)->update(['Approved' => false]);

        

        $names = User::all();
        $username = User::where('id', $id)->value('name');
        $mail = User::where('id', $id)->get();

        $data = array(
                
            'name'      =>  'ClickNet Member',
            'subject'   =>  'Clicknet Application Status',
            // 'email'  =>  $request->email,
            'message'   =>   'We are sorry to inform you that your request to join Clicknet has been declined.
                            Major reasons why access is denied is not following admin rules.
                            You can try again later.
                            Regards Clicknet Team
            '
        );

        // $mail = $request->input('email');
        
            Mail::to($mail)->send(new SendMail($data));

        return redirect()->back()->with('error', 'Denied approval!');

    }

    public function adminsite()
    {

        $adminid = User::where('admin', 1)->value('id');
        $adminclick = Clicks::where('OwnerId', $adminid)->orderBy('id', 'DESC')->paginate(20);

        $adminclickcount = Clicks::where('OwnerId', $adminid)->count();
        
       
        return view('admin.adminsite')->with('adminclick', $adminclick)->with('adminclickcount', $adminclickcount);

    }


    public function sendmail()
    {
            return view('admin.sendemails');

    }

    public function sendmailform1(Request $request)
    {


            $data = array('name'=>"Prince");
         
            Mail::send(['html'=>'mail'], $data, function($message) {

                
            
               $message->to('atdigitalafrica@gmail.com', 'ClickNet Member')->subject('ClickNet Team');
               $message->from('xyz@gmail.com','ClickNet');
            });
            // echo "Basic Email Sent. Check your inbox.";
         
      
            return redirect()->back()->with('success', 'Sent successfully!');

    }

    public function sendmailform(Request $request)
    {
     $this->validate($request, [
        // 'name'     =>  'required',
        'subject'     =>  'required',
        // 'email'  =>  'required|email',
      'message' =>  'required'
     ]);
    
         $users = User::all();

        //  $name = User::find($users->name);

            $data = array(
                
                'name'      =>  'ClickNet Member',
                'subject'   =>  $request->subject,
                // 'email'  =>  $request->email,
                'message'   =>   $request->message
            );
    
            // $mail = $request->input('email');
            foreach($users as $users) {
                Mail::to($users)->send(new SendMail($data));
            
             }        
     
     return back()->with('success', 'Email sent completed !');

    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
