@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 pt-2">
               <div class="row">
                    <div class="col-8">
                        <h1 class="display-one">Contacts</h1>
                        <p>all contacts</p>
                    </div>
                    <div class="col-4">
                        <p>Create new contact</p>
                        <a href="/contacts/create" class="btn btn-primary btn-sm">Add Contact</a>
                    </div>
               </div>
                <ul>
                    <li><a href="/contacts/export">Экспорт</a></li>
                    <li>
                        <form action="/contacts/import" method="POST" enctype="multipart/form-data">
                          <label for="import_contact">Импорт</label>
                          <input type="file" id="import_contact" name="contacts"><br/>
                          <input type="submit">
                        @csrf
                        </form>
                    </li>
                </ul>
            @forelse($contacts as $contact)
                <ul>
                    <li><a href="./contacts/{{$contact->id}}">{{ (!empty($contact->firstname)) ? ucfirst($contact->firstname) : 'не указано'}}</a></li>
                </ul>
            @empty
                <p class="text-warning">No contacts available</p>
            @endforelse
            </div>
        </div>
    </div>
@endsection
