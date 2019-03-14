<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS EDGE</title>
</head>

<style>
    .mainWrapper{
        width: 80%;
        height: 600px;
        margin: 0 auto;
        text-align: center;
        background-color: #f8ffbe;
    }
    .formWrapper{
        margin-bottom: 25px;
    }
    table{
        width: 70%;
        padding: 25px;
        margin: 0 auto;
    }
    table, th, td {
        border: 1px solid black;
    }

</style>

<body>
<div class="mainWrapper">
    <h1>Hello</h1>
    <form class="formWrapper" method="get" action="filter">
        <div class="filterWrapper">
            <span>user name</span>
            <select name="user_id">
                 <option value="0">all</option>
                 @foreach($users as $user)
                     <option value="{{$user->id}}">{{$user->user_name}}</option>
                 @endforeach
             </select>
            <span>country name</span>
            <select name="country_id">
                <option value="0">all</option>
                @foreach($countries as $country)
                    <option value="{{$country->id}}">{{$country->country_name}}</option>
                @endforeach
            </select>
            <span>from</span> <input type="date" name="from" value="" required>
            <span>to</span> <input type="date" name="to" value="" required>

            <button type="submit">Filter</button>
        </div>
    </form>
    @if(isset($message))
        <table>
            <tr>
                <th>Date</th>
                <th>Successfully sent </th>
                <th>Failed</th>
            </tr>
            @foreach($message as  $key=>$msg)
                <tr>
                    <td>{{$key}}</td>
                    <td>{{isset($msg['success']) ? $msg['success'] : 0}}</td>
                    <td>{{isset($msg['fail']) ? $msg['fail'] : 0}}</td>
                </tr>
            @endforeach

        </table>
    @endif

</div>

</body>
</html>

