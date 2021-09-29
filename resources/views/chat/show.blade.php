@extends('layouts.app')

@push('styles')

<style type="text/css">
   #users>li {
      cursor: pointer;
   }
</style>

@endpush




@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-12">
         <div class="card">
            <div class="card-header">{{ auth()->user()->name }}</div>

            <div class="card-body">
               <div class="row p-2">

                  <div class="col-10">
                     <div class="row">
                        <div class="col-12 border rounded-lg p-3">
                           {{-- <ul id="messages" class="list-unstyled overflow-auto" style="height: 45vh">

                           </ul> --}}
                           <div id="messages" style="height: 45vh">

                           </div>
                        </div>
                        <form action="" class="px-0">
                           <div class="row py-3">
                              <div class="col-10">
                                 <input type="text" id="message" class="form-control">
                              </div>
                              <div class="col-2 d-grid">
                                 <button id="send" type="submit" class="btn btn-primary">Send</button>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>

                  <div class="col-2">
                     <p><strong>Online Now</strong></p>
                     <ul id="users" class="list-unstyled overflow-auto text-info">

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
   const usersElement = document.getElementById('users');
   const messagesElement = document.getElementById('messages');

   Echo.join('chat')
         .here( (users) => {
            users.forEach( (user, index) => {
               let element = document.createElement('li');

               element.setAttribute('id', user.id);
               element.setAttribute('onclick', 'greetUser("' + user.id + '")');
               element.innerText = user.name;
               usersElement.appendChild(element);
            });
         })
         .joining( (user) => {
            let element = document.createElement('li');

            element.setAttribute('id', user.id);
            element.setAttribute('onclick', 'greetUser("' + user.id + '")');
            element.innerText = user.name;
            usersElement.appendChild(element);
            
         })
         .leaving( (user) => {
            let element = document.getElementById(user.id);
            element.parentNode.removeChild(element);
         })
         .listen('MessageSend', (e) => {
            let element = document.createElement('div');

            element.classList.add('col-6', 'p-2', 'rounded', 'text-white', 'mt-2', 'bg-success')
            element.innerText = e.user.name + ':' + e.message;
            messagesElement.appendChild(element);
         
         });
</script>

<script>
   // Enviar mensajes desde input hcia chat
   const sendElement = document.getElementById('send');
   const messageElement = document.getElementById('message');

   sendElement.addEventListener('click', (e) => {
      e.preventDefault();

      window.axios.post('/chat/message', {
         message : messageElement.value
      });

      messageElement.value = '';
   });
</script>

<script>
   function greetUser(id){
      window.axios.post('/chat/greet/' + id);
   }
</script>

<script>
   Echo.private('chat.greet.{{ auth()->user()->id }}')
      .listen('GreetSend', (e) => {
         let element = document.createElement('div');

      element.innerText = e.message;
      element.classList.add('col-6', 'p-2', 'rounded', 'text-white', 'mt-2', 'bg-info')
      messagesElement.appendChild(element);
      })
</script>

@endpush