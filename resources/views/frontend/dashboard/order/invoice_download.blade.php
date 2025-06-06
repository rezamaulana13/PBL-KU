<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Invoice</title>

<style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
    }
    table{
        font-size: x-small;
    }
    tfoot tr td{
        font-weight: bold;
        font-size: x-small;
    }
    .gray {
        background-color: lightgray
    }
    .font{
      font-size: 15px;
    }
    .authority {
        /*text-align: center;*/
        float: right
    }
    .authority h5 {
        margin-top: -10px;
        color: green;
        /*text-align: center;*/
        margin-left: 35px;
    }
    .thanks p {
        color: green;;
        font-size: 16px;
        font-weight: normal;
        font-family: serif;
        margin-top: 20px;
    }
</style>

</head>
<body>

  <table width="100%" style="background: #F7F7F7; padding:0 20px 0 20px;">
    <tr>
        <td valign="top">
          <!-- {{-- <img src="" alt="" width="150"/> --}} -->
          <h2 style="color: rgb(218, 233, 7); font-size: 26px;"><strong>RaraCookies</strong></h2>
        </td>
        <td align="right">
            <pre class="font" >
               RaraCookies Head Office
               Email:raracookies@gmail.com <br>
               Mob: 1245454545 <br>
               Eka Mayasari #1 <br>

            </pre>
        </td>
    </tr>

  </table>


  <table width="100%" style="background:white; padding:2px;"></table>

  <table width="100%" style="background: #F7F7F7; padding:0 5 0 5px;" class="font">
    <tr>
        <td>
          <p class="font" style="margin-left: 20px;">
           <strong>Nama:</strong> {{ $order->name }} <br>
           <strong>Email:</strong> {{ $order->email }} <br>
           <strong>No.Hp:</strong> {{ $order->phone }} <br>
           <strong>Alamat:</strong> {{ $order->address }}

         </p>
        </td>
        <td>
          <p class="font">
            <h3><span style="color: green;">Invoice:</span> #{{ $order->invoice_no }}</h3>
            Tanggal Pembelian: {{ $order->order_date }} <br>
            Tipe Pembayaran {{ $order->payment_method }} </span>
         </p>
        </td>
    </tr>
  </table>
  <br/>
<h3>Produk</h3>


  <table width="100%">
    <thead style="background-color: green; color:#FFFFFF;">
      <tr class="font">
        <th>Gambar</th>
        <th>Nama Produk</th>
        <th>Kode</th>
        <th>Quantity</th>
        <th>Nama Toko</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>

     @foreach ($orderItem as $item)
      <tr class="font">
        <td align="center">
         <img src="{{ public_path($item->product->image) }}" height="60px;" width="60px;" alt="">
        </td>
        <td align="center">{{ $item->product->name }}</td>
        <td align="center">{{ $item->product->code }}</td>
        <td align="center">{{ $item->qty }}</td>
        <td align="center">{{ $item->product->client->name }}</td>
        <td align="center">{{ $item->price }}</td>
      </tr>
     @endforeach
    </tbody>
  </table>
  <br>
  <table width="100%" style=" padding:0 10px 0 10px;">
    <tr>
        <td align="right" >
            <h2><span style="color: green;">Subtotal:</span> Subtotal</h2>
            <h2><span style="color: green;">Total:</span>
                {{ $totalPrice }}</h2>
            {{-- <h2><span style="color: green;">Full Payment PAID</h2> --}}
        </td>
    </tr>
  </table>
  <div class="thanks mt-3">
    <p>Terima Kasih Sudah Membeli Produk Kami !!.. </p>
  </div>
  <div class="authority float-right mt-5">
      <p>-----------------------------------</p>
      <h5>Tertanda</h5>
    </div>
</body>
</html>
