<table>
    <thead>
    <tr>
        <th>id</th>
        <th>Фамилия</th>
        <th>Имя</th>
        <th>Отчество</th>
        <th>email</th>
        <th>телефон</th>
        <th>теги</th>
    </tr>
    </thead>
    <tbody>
    @foreach($contacts as $contact)
    <tr>
        <td>
            @empty($contact->id)

            @else
                {{$contact->id}}
            @endempty
            </td>
        <td>
            @empty($contact->lastname)

            @else
                {{$contact->lastname}}
            @endempty
            </td>
        <td>
            @empty($contact->firstname)

            @else
                {{$contact->firstname}}
            @endempty
        </td>
    <td>
        @empty($contact->patrony)

        @else
            {{$contact->patrony}}
        @endempty
    </td>
    <td>
        @empty($contact->email)

        @else
            {{$contact->email}}
        @endempty
    </td>
    <td>
        @empty($contact->phone)

        @else
            {{$contact->phone}}
        @endempty
    </td>
    <td>
        {{ $contact->tags->pluck('text')->implode(', ') }}
    </td>

    </tr>
    @endforeach
    </tbody>
</table>
