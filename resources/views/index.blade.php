<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mevduat Faiz Hesaplama</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h3 class="text-center">Mevduat Faizi Hesaplama</h3>
    <div class="card p-4 mb-4">
        <div class="form-group">
            <label for="principal">Ana Para</label>
            <input type="number" id="principal" class="form-control" placeholder="Ana parayı girin">
        </div>
        <div class="form-group">
            <label for="currency">Para Birimi</label>
            <select id="currency" class="form-control">
               @foreach($currencies as $currency)
                    <option value="{{$currency}}">{{$currency}}</option>
               @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="term">Vade (Gün)</label>
            <select id="term_days" class="form-control">
                @foreach($termDays as $termDay)
                    <option value="{{$termDay}}">{{$termDay}} Gün</option>
                @endforeach
                <option value="custom">Özel Vade Gir</option>
            </select>
            <input type="number" id="customTerm" class="form-control mt-2" placeholder="Özel vade (gün)" style="display: none;">
        </div>
        <button id="calculate" class="btn btn-primary btn-block">Hesapla</button>
    </div>
    <div class="card p-4">
        <h4>Sonuçlar</h4>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Banka Adı</th>
                <th>Faiz Oranı (%)</th>
                <th>Ana Para</th>
                <th>Faiz Geliri</th>
                <th>Vade Sonu Tutar</th>
            </tr>
            </thead>
            <tbody id="results"></tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Vade seçeneği özel seçildiğinde, manuel giriş alanını göster
        $('#term_days').on('change', function() {
            if ($(this).val() === 'custom') {
                $('#customTerm').show();
            } else {
                $('#customTerm').hide();
                $('#customTerm').val(''); // Seçim değiştiğinde alanı temizle
            }
        });

        // Hesaplama butonuna tıklanınca AJAX isteği gönder
        $('#calculate').on('click', function() {
            let principal = $('#principal').val();
            let currency = $('#currency').val();
            let term = $('#term_days').val() === 'custom' ? $('#customTerm').val() : $('#term_days').val();
            console.log(principal, currency, term);
            if (!principal || !term) {
                alert('Lütfen tüm bilgileri eksiksiz girin.');
                return;
            }

            $.ajax({
                url: '/api/v1/interest-rates/calculate',
                method: 'POST',
                data: {
                    principal: principal,
                    currency: currency,
                    term: term
                },
                success: function(response) {
                    let resultHtml = '';
                    response.data.forEach(result => {
                        resultHtml += `<tr>
                            <td>${result.bank.name}</td>
                            <td>${result.interest_rate.rate}%</td>
                            <td>${result.principal} ${result.currency}</td>
                            <td>${result.interest.toFixed(2)} ${result.currency}</td>
                            <td>${(result.principal+ result.interest).toFixed(2)} ${result.currency}</td>
                        </tr>`;
                    });
                    $('#results').html(resultHtml);
                },
                error: function(xhr) {
                    alert('Hata oluştu: ' + xhr.responseText);
                }
            });
        });
    });
</script>

</body>
</html>
