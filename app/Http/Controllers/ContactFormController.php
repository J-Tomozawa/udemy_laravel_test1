<?php

namespace App\Http\Controllers;

use App\Models\ContactForm;
use Illuminate\Http\Request;
use App\Services;
use App\Services\CheckFormService;
use App\Http\Requests\StoreContactRequest;

use function Ramsey\Uuid\v1;

class ContactFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $contacts = ContactForm::select('id', 'name', 'title', 'created_at')->get();
        
        // $contacts = ContactForm::select('id', 'name', 'title', 'created_at')->paginate(20);
        // return view('contacts.index', compact('contacts'));

        $search = $request->search;
        $query =  ContactForm::Search($search);
        $contacts = $query->select('id', 'name', 'title', 'created_at')->paginate(20);
        return view('contacts.index', compact('contacts'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactRequest $request)
    {
        // dd($request);
        ContactForm::create([
            'name' => $request->name,
            'title' => $request->title,
            'email' => $request->email,
            'url' => $request->url,
            'gender' => $request->gender,
            'age' => $request->age,
            'contact' => $request->contact,

        ]);

        return to_route('contacts.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contact = ContactForm::find($id);
        
        // if($contact->gender === 0) {
        //     $gender = '男性';
        // } else {
        //     $gender = '女性';
        // }
        $gender = CheckFormService::checkGender($contact);
        
        // if($contact->age === 1 ){ $age = '～19歳'; }
        // if($contact->age === 2 ){ $age = '20歳～29歳'; }
        // if($contact->age === 3 ){ $age = '30歳～39歳'; }
        // if($contact->age === 4 ){ $age = '40歳～49歳'; }
        // if($contact->age === 5 ){ $age = '50歳～59歳'; }
        // if($contact->age === 6 ){ $age = '60歳～'; } 
        $age = CheckFormService::checkAge($contact);
        
        return view('contacts.show', compact('contact', 'gender', 'age'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contact = ContactForm::find($id);
        
        return view('contacts.edit', compact('contact'));
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
        $contact = ContactForm::find($id);
        // dd($contact);
        
        $contact->name = $request->name;
        $contact->title = $request->title;
        $contact->email = $request->email;
        $contact->url = $request->url;
        $contact->gender = $request->gender;
        $contact->age = $request->age;
        $contact->contact = $request->contact;
        $contact->save();

        return to_route('contacts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = ContactForm::find($id);
        // dd($contact);
        $contact->delete();

        return to_route('contacts.index');
    }
}
