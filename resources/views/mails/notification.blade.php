<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$subject}}</title>
</head>
<body style="font-family: Arial, sans-serif!important; background-color: #f0f0f0!important; margin: 0!important; padding: 50px!important;">
    <div style="font-family: Arial, sans-serif; background-color: #f0f0f0; margin: 0; padding: 0;">
        <div style="max-width: 600px; min-height: 500px; margin: 0 auto; padding: 20px; background-color: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            <div style="margin-bottom: 100px; display: flex; justify-content:center;">
                <img src="{{env('APP_URL')}}/img/pacoca.png" style="height: 150px; margin: 0 auto;" class="img">
            </div>
            <h2>{!! $subject !!}</h2>
            <p style="font-size: 17px">{!! $lineText !!}</p>
            <table style="margin: 0 auto;" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <a href="{{$url}}" style="display: inline-block; background-color: #5bb4ff; color: #fff; padding: 15px 45px; text-decoration: none; border-radius: 5px;">{{$actionText}}</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
