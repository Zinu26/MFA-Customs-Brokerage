<!DOCTYPE html>
<html>
<head>
    <title>Chatbot</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Chatbot</h1>
    <form>
        <label for="faq">Select FAQ:</label>
        <select id="faq" name="faq">
            @foreach ($faqs as $faq)
                <option value="{{ $faq->question }}">{{ $faq->question }}</option>
            @endforeach
        </select>
        <button type="submit">Submit</button>
    </form>
    <div id="answer"></div>

    <script>
        $('form').submit(function(e) {
            e.preventDefault();
            var selectedFaq = $('#faq').val();
            $.ajax({
                type: 'POST',
                url: '{{ route("sendChat") }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    faq: selectedFaq
                },
                success: function(data) {
                    $('#answer').html(data.answer);
                }
            });
        });
    </script>
</body>
</html>
