<table>
  <thead>
    <tr>
      <th>id</th>
      <th>name</th>
      <th>institute_type</th>
      <th>address</th>
      <th>city</th>
      <th>state</th>
      <th>country</th>
      <th>email</th>
      <th>email2</th>
      <th>email3</th>
      <th>phone_number</th>
      <th>phone_number2</th>
      <th>phone_number3</th>
      <th>whatsapp</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($rows as $row)
      <tr>
        <td>{{ $row->id }}</td>
        <td>{{ $row->name }}</td>
        <td>{{ $row->institute_type }}</td>
        <td>{{ $row->address }}</td>
        <td>{{ $row->city }}</td>
        <td>{{ $row->state }}</td>
        <td>{{ $row->country }}</td>
        <td>{{ $row->email }}</td>
        <td>{{ $row->email2 }}</td>
        <td>{{ $row->email3 }}</td>
        <td>{{ $row->phone_number }}</td>
        <td>{{ $row->phone_number2 }}</td>
        <td>{{ $row->phone_number3 }}</td>
        <td>{{ $row->whatsapp }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
