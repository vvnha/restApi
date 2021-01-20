<base href="{{asset('')}}">
<style type="text/css">
      
    body {
    margin: 0;
    padding: 0;
    background-color: #FAFAFA;
    font: 12pt "Tohoma";
}
* {
    box-sizing: border-box;
    -moz-box-sizing: border-box;
}
.page {
    width: 21cm;
    overflow:hidden;
    min-height:297mm;
    padding: 2cm;
    margin-left:auto;
    margin-right:auto;
    background: white;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}

 @page {
 size: A4;
 margin: 0;
}
button {
    width:100px;
    height: 24px;
}
.header {
    overflow:hidden;
}
.company {
    padding-top:0px;
    text-transform:uppercase;
    background-color:#FFFFFF;
    text-align:right;
    float:right;
    font-size:18px;
}
.title {
    text-align:center;
    position:relative;
    color:#0000FF;
    font-size: 24px;
    top:1px;
}

.TableData {
    background:#ffffff;
    font: 11px;
    width:100%;
    border-collapse:collapse;
    font-family:Verdana, Arial, Helvetica, sans-serif;
    font-size:12px;
    border:thin solid #d3d3d3;
}
.TableData TH {
    background: rgba(0,0,255,0.1);
    text-align: center;
    font-weight: bold;
    color: #000;
    border: solid 1px #ccc;
    height: 24px;
}
.TableData TR {
    height: 24px;
    border:thin solid #d3d3d3;
}
.TableData TR TD {
    padding-right: 2px;
    padding-left: 2px;
    border:thin solid #d3d3d3;
}
.TableData TR:hover {
    background: rgba(0,0,0,0.05);
}
.TableData .cotSTT {
    text-align:center;
    width: 10%;
}
.TableData .cotTenSanPham {
    text-align:left;
    width: 40%;
}
.TableData .cotHangSanXuat {
    text-align:left;
    width: 20%;
}
.TableData .cotGia {
    text-align:right;
    width: 120px;
}
.TableData .cotSoLuong {
    text-align: center;
    width: 50px;
}
.TableData .cotSo {
    text-align: right;
    width: 120px;
}
.TableData .tong {
    text-align: right;
    font-weight:bold;
    text-transform:uppercase;
    padding-right: 4px;
}
.TableData .cotSoLuong input {
    text-align: center;
}
@media print {
 @page {
 margin: 0;
 border: initial;
 border-radius: initial;
 width: initial;
 min-height: initial;
 box-shadow: initial;
 background: initial;
 page-break-after: always;
}
}
.khachhang{
    height: 4px;
}
</style>

<body onload="window.print();">
<div id="page" class="page">
    <div class="header">
       <!--  <div class="logo"><img src="public\img\logoress.jpg"/></div> -->
        <div class="company">restaurant qn<br/> 
            <p style="font-size:12px;">SDT: 098762345</p>
        </div><br/>
    </div>
  <br/>
  <div class="title">
        HÓA ĐƠN THANH TOÁN
        <br/>
        -------oOo-------
  </div>
  <br/>
    <p class="khachhang">Ngày: {{$date}}</p>
    <p class="khachhang">Bàn: {{$perNum}}</p>
    <p class="khachhang">Thu ngân: {{$nameA}} </p>
    <p class="khachhang">Mã HĐ: 00{{$id}}</p>
    <p class="khachhang">Khách hàng: {{$userss->name}}</p>
    <p class="khachhang">Điện thoại: {{$userss->phone}}</p>
    <br/>
  <table class="TableData">
    <tr>
      <th>STT</th>
      <th>Tên</th>
      <th>Đơn giá</th>
      <th>Số</th>
      <th>Thành tiền</th>
    </tr>
    
    <p hidden="">{{$tongsotien=0}}</p>
    @foreach($foods as $value)
        
        <tr>
            <td class="cotSTT">{{$stt++}}</td>
            <td class="cotTenSanPham">{{$value->foodName}}</td>
            <td class="cotGia">{{number_format($value->price,0,",",".")}}</td>
            <td class="cotSoLuong" align="center">{{$value->qty}}</td>
            <td class="cotSo">{{number_format(($prices = $value->qty*$value->price),0,",",".")}}</td>
            <p hidden="">{{$tongsotien+=$prices}}</p>
        </tr>
    @endforeach
    <tr>
      <td colspan="4" class="tong">Tổng cộng</td>
      <td class="cotSo"><?php echo number_format(($tongsotien),0,",",".")?> vnđ</td>
    </tr>
  </table>
</div>
</body>