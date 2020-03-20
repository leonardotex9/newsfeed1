<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;

class JobManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
       $alljobs = DB::table('wingg_app_user')->get();
	  // dd($alljobs);
      return view('admin.news',compact('alljobs'));
      // return view('/admin.job_management');
    }
    public function blogs()
    {
       $alljobs = DB::table('fa_jobpost')->orderBy('id','desc')->get();
       $allblogs = DB::table('fa_blogs')->orderBy('id','desc')->get();
       return view('/admin.blogs',compact('alljobs','allblogs'));
    }

     public function admin_login(Request $request)
    {
         if ($request->session()->exists('chat_admin')) {
            return redirect('/dashboard');
        }


		if($request->isMethod('post')){
//dd($request->all());
//            $user_type = $request->input('user_type');


           $email = $request->input('email');
            $password = trim($request->input('password'));
            $ch = curl_init();
//dd("email=$email&password=$password");
            curl_setopt($ch, CURLOPT_URL,"https://api.wingg.com/auth/login/");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,
                        "email=$email&password=$password");

            // In real life you should use something like:
            // curl_setopt($ch, CURLOPT_POSTFIELDS,
            //          http_build_query(array('postvar1' => 'value1')));

            // Receive server response ...
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $server_output = curl_exec($ch);

            curl_close ($ch);
              $auth=json_decode($server_output);
							// dd($auth);
              try {
             $user = DB::table('wingg_app_user')->where('id', $auth->user_id)->first();
				$request->session()->put('chat_admin', $user);
				setcookie('cc_data', $user->id, time() + (86400 * 30), "/");


					return redirect('dashboard');
            } catch (Exception $e) {
                report($e);
            	$request->session()->flash('loginAlert', 'Invalid Email & Password');

			    return redirect('admin/login');
            }
           // dd($auth);
            // Further processing ...
            // if ($server_output == "OK") { ... } else { ... }
			// if($auth){
            //     dd($auth);
			// 	$request->session()->flash('loginAlert', 'Invalid Email & Password');

			// 		return redirect('admin/login');

			// }
			// else{
               // dd($auth);


			//}


		}
        return view('/admin.login-page');
    }

    public function doLogin($email,$password){
        /* do login */
        //dd($password);
        $user = DB::table('chat_admin')->insert(['name'=>'nabeel','email'=>$email,'role'=>'admin','password'=>$password]);

        if(empty($user)){
            return 'invalid';
        }else{
            return $user;
        }
		/* end */
	}

 public function logout(Request $request){
         //Session::flush();
         Session::forget('chat_admin');
         return redirect('admin/login');
        }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
public function template(Request $request, $id)
    {
      // dd($request->all());
        if($request->isMethod('post')){
            $this->validate($request, [
                'phone_number' => 'required',
                'email' => 'required',
                'location'=>'required',
                'mbl_number' => 'required|digits_between:10,12',
                'business_address' => 'required',
                'phone_number' => 'required',
                'company_name' => 'required'

            ],[
                'phone_number.required'=>'Enter your phone number',
                'email.required' => 'Enter valid email',
                'location.required' => 'Enter your location',
                'mbl_number.required' =>'Enter Your Mobile Number',
                'business_address.required' => 'Enter business address ',
                'phone_number.required'=>'Enter mobile number',
                'mbl_number.digits_between' => 'mobile Number must be contain 10,12 digits',
                'company_name' => 'Enter company name',
            ]);

            $request->merge(['job_id' => $id]);
            $request->merge(['service_needed' => @json_encode($request->input('service_needed'))]);
            $request->merge(['service_required' => @json_encode($request->input('service_required'))]);
           // dd($data);
           $res= DB::table('fa_user_template')->where('job_id',$id)->first();
          // dd($request->all());
            if(empty($res))
            {
                $temp = DB::table('fa_user_template')->insert($request->all());
            }
            else
            {
                $temp = DB::table('fa_user_template')->where('job_id',$id)->update($request->all());
            }

        DB::table('fa_jobpost')->where('id',$id)->update(['status'=>'1']);
       //dd($request->all());
            $request->session()->flash('message','Detail added successfully');
            return redirect()->back();
        }

          $autofil=DB::table('fa_jobpost')->where('id',$id)->first();
        $template=DB::table('fa_user_template')->where('job_id',$id)->first();
          // dd($template);
        $job = DB::table('fa_jobpost')->where('id',$id)->first();
        // dd($job);
       return view('/admin.add_template',compact('job','template','autofil'));
    }
    public function visit(Request $request)
    {
        $id=$request->all();

        $allquote1=DB::table('fa_jobpost')->where('id',$id['visit_id'])->update(['visited'=>'visited']);

		$allquote = DB::table('fa_jobpost')->select('fa_quote.*','fa_jobpost.services','fa_jobpost.city','fa_jobpost.job_title','fa_jobpost.customer_name','fa_jobpost.mobilenumber','fa_jobpost.city','fa_jobpost.job_case','fa_jobpost.job_type')->join('fa_quote','fa_quote.job_id','=','fa_jobpost.id')->orderBy('fa_quote.id','desc')->paginate(15);
       foreach($allquote as &$ser){

            $ser->partner = DB::table('fa_partner')->where('p_id','=',$ser->p_id)->first();
         }

        return $allquote;

    }
     public function showtemplate()
    {
        $template=DB::table('fa_template')
        ->join('fa_jobpost','fa_jobpost.id','=','fa_template.job_id')
        ->orderBy('fa_template.temp_id','desc')->get();
       // dd($template);
        return view('/admin.make_template',compact('template'));
    }

    public function quotes()
    {
       $allquote = DB::table('fa_jobpost')->select('fa_jobpost.id','fa_jobpost.services','fa_jobpost.visited','fa_jobpost.city','fa_jobpost.job_title','fa_jobpost.customer_name','fa_jobpost.mobilenumber','fa_jobpost.city','fa_jobpost.job_case','fa_jobpost.job_type','fa_jobpost.status_from_admin','fa_jobpost.outcome','fa_jobpost.admin_comment','fa_jobpost.admin_update','fa_jobpost.admin_id')->where('quote_status','1')->orderBy('fa_jobpost.id','desc')->groupBy('fa_jobpost.id')->paginate(15);
       foreach($allquote as &$ser){

            $ser->qoutes = DB::table('fa_quote')->where('job_id','=',$ser->id)->orderBy('id','desc')->get();

	   foreach($ser->qoutes  as &$qoute){

            $qoute->partner = DB::table('fa_partner')->where('p_id','=',$qoute->p_id)->first();
         }

         }
       // dd( $allquote);
        return view('/admin.quotes',compact('allquote'));
    }

    public function post_portal(Request $request)
    {
        $id=$request->input('job_id');
        $value=$request->input('value');
       // dd($request->all());
        $allquote = DB::table('fa_jobpost')->where('id',$id)->update(['post_portal'=>$value]);
        return $allquote;
    }
  public function mark(Request $request)
    {
        $id=$request->input('id');
        $value=$request->input('value');

         $quotedata= DB::table('fa_quote')->where('id',$id)->update(['mark'=>$value]);
  return $quotedata;
   }
   public function jobstatus_update(Request $request,$id)
    {
        $admin_data=$request->session()->get('chat_admin')->name;
        //dd($admin_data);
        if ($request->isMethod('post')) {
            $request->merge(['admin_id' => $admin_data]);
            $request->merge(['admin_update' => date("Y-m-d h:i")]);
           // dd($request->all());
            $allquote = DB::table('fa_jobpost')->where('id',$id)->update($request->all());
            return redirect('dashboard/quotes');
    }
    $update = DB::table('fa_jobpost')->select('outcome','status_from_admin','admin_comment')->where('id',$id)->first();
//dd($update);
        return view('/admin.job_update',compact('update'));
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
    public function destroy(Request $request,$id)
    {
        DB::table('fa_jobpost')->where('id',$id)->delete();
        DB::table('fa_template')->where('job_id',$id)->delete();
        $request->session()->flash('message','Job deleted successfully');
        return redirect()->back();
    }
}
