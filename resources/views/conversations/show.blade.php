@extends("template")
@section("title", $conversation->name)
@section('style')
    <style>
        .bg-light {
            background-color: rgb(220 228 236) !important;;
        }

        .mw-lg-400px {
            max-width: 500px;
        }

        .min-w-150px {
            min-width: 20px;
        }
    </style>
@endsection
@section("master")
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{$conversation->name}}</h3>
        </div>
        <div class="card-body">
            <div class="px-2" style="height: 350px; overflow-y: auto;" data-message="container">
                @foreach($conversation->messages as $item)
                    <div class="mb-4">
                        <div
                            class="d-flex align-items-center gap-2 mb-1 {{$item->user_id === auth()->id()? 'justify-content-end' : 'justify-content-start'}}">
                            <div>
                                <div class="fw-bold" style="font-size: 14px">{{$item->user->name}}</div>
                                <div class="text-muted fw-bold" style="font-size: 11px">{{$item->get_created_at}}</div>
                            </div>
                        </div>
                        <div
                            class="d-flex {{$item->user_id === auth()->id()? 'justify-content-end' : 'justify-content-start'}}">
                            <div
                                class="p-2 rounded bg-light text-gray-900 fw-semibold mw-lg-400px min-w-150px text-start"
                                style="font-size: 14px">
                                {{$item->message}}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="fw-semibold opacity-0" data-typing-indicator="container" style="font-size: 0.75rem;">
                <span data-typing-indicator="name"> </span> is typing...
            </div>
            <form id="sendMessageForm" class="d-flex mt-3 gap-1">
                @csrf
                <textarea id="textarea" name="message" rows="1" class="form-control"></textarea>
                <div class="d-flex align-items-center">
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
            </form>
        </div>
    </div>

    <div class="d-none" data-message="empty-item">
        <div class="mb-4">
            <div class="area-1 d-flex align-items-center justify-content-start gap-2 mb-1">
                <div>
                    <div class="fw-bold user-name" style="font-size: 14px"></div>
                    <div class="text-muted fw-bold time" style="font-size: 11px"></div>
                </div>
            </div>
            <div class="area-2 d-flex justify-content-start">
                <div class="p-2 rounded bg-light fw-semibold mw-lg-400px text-start message"
                     style="font-size: 14px"></div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @vite(['resources/js/app.js'])
    <script>
        $(document).ready(function () {
            const authUserId = '{{auth()->id()}}';
            const conversationId = '{{$conversation->id}}';
            const emptyItem = $('[data-message="empty-item');
            const messageContainer = $('[data-message="container');
            const typingIndicatorContainer = $('[data-typing-indicator="container"]');

            const drawMessage = (message) => {
                if (!message || !message?.id) return;

                if (message.user_id == authUserId) {
                    emptyItem.find('.area-1').removeClass('justify-content-start').addClass('justify-content-end');
                    emptyItem.find('.area-2').removeClass('justify-content-start').addClass('justify-content-end');
                    emptyItem.find('.area-2').removeClass('justify-content-start').addClass('justify-content-end');
                } else {
                    emptyItem.find('.area-1').removeClass('justify-content-end').addClass('justify-content-start');
                    emptyItem.find('.area-2').removeClass('justify-content-end').addClass('justify-content-start');
                    emptyItem.find('.area-2').removeClass('justify-content-end').addClass('justify-content-start');
                }
                emptyItem.find('.item').attr('data-id', message.id)
                emptyItem.find('.user-name').text(message.user_name ?? message.user.name)
                emptyItem.find('.message').html(message.message.replace(/\n/g, '<br>'));
                emptyItem.find('.time').text(message.get_created_at)

                messageContainer.append(emptyItem.html())
                messageContainer.scrollTop(messageContainer[0].scrollHeight);

                emptyItem.find('.item').attr('data-id', null)
                emptyItem.find('.user-name').text(null)
                emptyItem.find('.message').html(null);
                emptyItem.find('.time').text(null)
            }

            $(document).on('input', '#textarea', function () {
                Echo.private(`conversation.${conversationId}`)
                    .whisper('typing', {
                        name: '{{auth()->user()->name}}'
                    });
            })

            let typingTimeout;
            Echo.private(`conversation.${conversationId}`)
                .listenForWhisper('typing', (e) => {
                    typingIndicatorContainer.removeClass('opacity-0').addClass('opacity-100')
                    $('[data-typing-indicator="name"]').text(e.name ?? '')

                    clearTimeout(typingTimeout);
                    typingTimeout = setTimeout(() => {
                        typingIndicatorContainer.removeClass('opacity-100').addClass('opacity-0')
                    }, 1000);
                });

            const channel = Echo.join(`conversation.${conversationId}`)
                .here((users) => {
                    console.log(users, 'here')
                })
                .joining((users) => {
                    console.log(users, 'joining')
                })
                .leaving((users) => {
                    console.log(users, 'leaving')
                }).listen('MessageSent', (e) => {
                    console.log(e, 'MessageSent')
                    drawMessage(e);
                });

            $(document).on('submit', '#sendMessageForm', function (e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '{{route('conversations.send-message', ['conversation' => $conversation->id])}}',
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    cache: false,
                    beforeSend: function () {
                        //
                    },
                    success: function (res) {
                        $('#sendMessageForm').find('[name="message"]').val('')
                        drawMessage(res?.data)
                    },
                    error: function (err) {
                        swal.fire({
                            title: 'Error',
                            text: err?.responseJSON?.message,
                            icon: "error",
                            showConfirmButton: 0,
                            showCancelButton: 1,
                            allowOutsideClick: false,
                            cancelButtonText: 'Close',
                        })
                    },
                    complete: function () {
                        //
                    }
                });
            })

            messageContainer.scrollTop(messageContainer[0].scrollHeight);
        })
    </script>
@endsection
