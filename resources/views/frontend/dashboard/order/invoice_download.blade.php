<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Invoice - {{ $order->invoice_no }}</title>

    <style type="text/css">
        /* Reset & Font */
        * {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.5;
        }
        body {
            color: #444444;
            font-size: 10px;
        }
        table {
            width: 100%;
            font-size: 10px;
            border-collapse: collapse;
        }

        /* Colors & Branding */
        .accent-navy {
            color: #003366;
        }
        .accent-gold {
            color: #B8860B;
        }
        .bg-navy {
            background-color: #003366;
            color: white;
        }
        .bg-light-gray {
            background-color: #F8F8F8;
        }
        .logo-text {
            font-size: 28px;
            font-weight: 900;
        }

        /* Layout & Typography */
        .header-block {
            padding: 20px;
            border-bottom: 3px solid #003366;
        }
        .info-label {
            color: #888888;
            font-size: 9px;
            text-transform: uppercase;
        }
        .info-value {
            font-size: 11px;
            font-weight: bold;
            margin-top: 3px;
        }
        .total-final {
            font-size: 14px;
            font-weight: bold;
        }
        .status-pill {
            display: inline-block;
            padding: 3px 8px;
            background-color: #28A745;
            color: white;
            border-radius: 4px;
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
        }

        /* Table Produk */
        .product-table th {
            padding: 10px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
        }
        .product-table td {
            padding: 8px 10px;
            border-bottom: 1px dashed #DDDDDD;
        }
    </style>

</head>
<body>

    @php
        // HITUNG SUBTOTAL DARI SEMUA ITEM PESANAN
        $subtotalPrice = 0;
        foreach ($order->orderItems as $item) {
            $subtotalPrice += $item->price * $item->qty;
        }
    @endphp

    <table width="100%" class="header-block">
        <tr>
            <td valign="top" width="50%">
                <div class="logo-text accent-gold">RaraCookies</div>
                <div style="font-size: 14px; font-weight: bold; margin-top: 5px;" class="accent-navy">INVOICE PEMBELIAN</div>
            </td>
            <td align="right" width="50%">
                <div class="info-label">DARI</div>
                <div class="info-value">RaraCookies Head Office</div>
                <div style="font-size: 10px;">
                    Eka Mayasari No. 1, Banyuwangi
                    <br>Email: raracookies@gmail.com
                    <br>Telp: +62 812 4545 4545
                </div>
            </td>
        </tr>
    </table>

    <table width="100%" style="margin-top: 25px;">
        <tr>
            <td width="45%" style="padding-right: 20px; border-right: 1px solid #EEEEEE;">
                <div style="font-size: 12px; font-weight: bold; margin-bottom: 10px;" class="accent-navy">DETAIL INVOICE</div>
                <table width="100%">
                    <tr>
                        <td width="30%" class="info-label">INVOICE NO</td>
                        <td width="70%" class="info-value accent-navy">#{{ $order->invoice_no }}</td>
                    </tr>
                    <tr><td colspan="2" style="padding: 2px 0;"></td></tr> <tr>
                        <td class="info-label">TANGGAL</td>
                        <td class="info-value">{{ $order->order_date }}</td>
                    </tr>
                    <tr><td colspan="2" style="padding: 2px 0;"></td></tr>
                    <tr>
                        <td class="info-label">PEMBAYARAN</td>
                        <td class="info-value">{{ $order->payment_method }}</td>
                    </tr>
                    <tr><td colspan="2" style="padding: 2px 0;"></td></tr>
                    <tr>
                        <td class="info-label">STATUS</td>
                        <td><span class="status-pill">{{ $order->status }}</span></td>
                    </tr>
                </table>
            </td>

            <td width="55%" style="padding-left: 20px;">
                <div style="font-size: 12px; font-weight: bold; margin-bottom: 10px;" class="accent-navy">INFO PELANGGAN & KIRIM</div>
                <table width="100%">
                    <tr>
                        <td width="30%" class="info-label">NAMA</td>
                        <td width="70%" class="info-value">{{ $order->name }}</td>
                    </tr>
                    <tr><td colspan="2" style="padding: 2px 0;"></td></tr>
                    <tr>
                        <td class="info-label">EMAIL/HP</td>
                        <td class="info-value">{{ $order->email }} / {{ $order->phone }}</td>
                    </tr>
                    <tr><td colspan="2" style="padding: 2px 0;"></td></tr>
                    <tr>
                        <td class="info-label" valign="top">ALAMAT KIRIM</td>
                        <td style="font-size: 11px;">{{ $order->address }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div style="margin-top: 35px; font-size: 14px; font-weight: bold;" class="accent-navy">RINCIAN PRODUK</div>

    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="product-table" style="margin-top: 8px;">
        <thead class="bg-navy">
            <tr>
                <th width="5%" style="color: white; padding-left: 15px;">#</th>
                <th width="30%" style="color: white;">Nama Produk</th>
                <th width="15%" style="color: white;">Kode</th>
                <th width="10%" style="color: white; text-align: center;">Qty</th>
                <th width="25%" style="color: white;">Toko</th>
                <th width="15%" style="color: white; text-align: right; padding-right: 15px;">Total Harga</th>
            </tr>
        </thead>
        <tbody>
            {{-- PERBAIKAN: Mengakses item melalui hubungan $order->orderItems --}}
            @foreach ($order->orderItems as $index => $item)
            <tr class="bg-light-gray" style="background-color: {{ $index % 2 == 0 ? '#FFFFFF' : '#F8F8F8' }};">
                <td align="center" style="padding-left: 15px;">{{ $index + 1 }}</td>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->product->code }}</td>
                <td align="center">{{ $item->qty }}</td>
                <td>{{ $item->product->client->name }}</td>
                {{-- PERBAIKAN: Menampilkan Total Harga (Harga Satuan * Qty) --}}
                <td align="right" style="font-weight: bold; padding-right: 15px;">Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table width="100%" style="margin-top: 30px;">
        <tr>
            <td width="60%" valign="top">
                <div style="font-size: 14px; font-weight: bold; margin-bottom: 20px;" class="accent-navy">
                    Terima Kasih atas kepercayaan Anda pada RaraCookies!
                </div>

                <div style="float: right; text-align: center; margin-top: 15px;">
                    <p style="margin: 0; font-size: 10px;">Hormat Kami,</p>
                    <div style="height: 40px;"></div> <p style="margin: 0; border-top: 1px solid #444; width: 150px; text-align: center; padding-top: 5px; font-weight: bold;">
                        Manajemen RaraCookies
                    </p>
                </div>
            </td>

            <td width="40%" align="right" valign="top">
                <table border="0" width="100%">
                    <tr style="font-size: 11px;">
                        <td style="padding: 5px 0;">Subtotal:</td>
                        {{-- PERBAIKAN: Menggunakan $subtotalPrice yang sudah dihitung --}}
                        <td align="right" style="padding: 5px 0;">Rp {{ number_format($subtotalPrice, 0, ',', '.') }}</td>
                    </tr>
                    {{-- Asumsi $order->shipping_cost tersedia --}}
                    {{-- <tr style="font-size: 11px;">
                        <td style="padding: 5px 0;">Biaya Kirim:</td>
                        <td align="right" style="padding: 5px 0;">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
                    </tr> --}}

                    <tr class="bg-navy">
                        <td style="padding: 10px; color: white;" class="total-final">TOTAL AKHIR:</td>
                        <td align="right" style="padding: 10px; color: white;" class="total-final">Rp {{ number_format($order->amount, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
