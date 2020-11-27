@extends('layouts.app')
@push('styles')
    <style>
        #users > li {
            cursor: pointer;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">Chat</div>

                    <div class="card-body">
                        <div class="row p-2">
                            <div class="col-10">
                                <div class="row">
                                    <div class="col-12 border rounded-lg p3-">
                                        <ul id="messages" class="list-unstyled overflow-auto" style="height: 45vh;">

                                        </ul>
                                    </div>
                                </div>
                                <div class="row py-3">
                                    <div class="col-10">
                                        <input id="message" type="text" class="form-control">
                                    </div>
                                    <div class="col-2">
                                        <button type="submit" id="send" class="btn btn-primary btn-block">Send</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <p><strong>Online now</strong></p>
                                <ul id="users" class="list-unstyled overflow-auto text-info" style="height: 45vh;">

                                </ul>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        const usersElements = document.getElementById('users');
        const messegesElement = document.getElementById('messages');

        Echo.join('chat')
            .here((users)=>{
                users.forEach((user,index)=>{
                    let element = document.createElement('li');
                    element.setAttribute('id',user.id);
                    element.setAttribute('onclick','greetUser()')
                    element.innerText = user.name;
                    usersElements.appendChild(element);
                });
            })
            .joining((user)=>{
                let element = document.createElement('li');
                element.setAttribute('id',user.id);
                element.setAttribute('onclick','greetUser("'+ user.id+'")')
                element.innerText = user.name;
                usersElements.appendChild(element);
            })
            .leaving((user)=>{
                let element = document.getElementById(user.id);
                element.parentNode.removeChild(element);
            })
            .listen('MessageSentEvent', (e) =>{
                let element = document.createElement('li');
                element.innerText = e.user.name + ': ' + e.message;
                messegesElement.appendChild(element);
            });
    </script>
    <script>
        const sendElement = document.getElementById('send');
        const messageElement = document.getElementById('message');

        sendElement.addEventListener('click', (e) =>{
            e.preventDefault();
            window.axios.post('/chat/message',{
                message: messageElement.value
            });
        });

        messageElement.value = '';

    </script>

    <script>
        function greetUser(id){
            window.axios.post('chat/greet/' + id);
        }
    </script>
    <script>
        Echo.private('chat.greet.{{auth()->user()->id}}')
            .listen('GreetingSent',(e)=>{
                let element = document.createElement('li');
                element.innerText = e.message;
                element.classList.add('text-success');
                messegesElement.appendChild(element);
            });
    </script>
@endpush
