<html><head>
<title></title>
<style type="text/css">
<!--
body {
  font-family:Tahoma;
}

img {
  border:0;
}

#page {
  width:800px;
  margin:0 auto;
  padding:15px;

}

#logo {
  float:left;
  margin:0;
}

#address {
  height:181px;
  margin-left:250px; 
}

table {
  width:100%;
}

td {
padding:5px;
}

tr.odd {
  background:#e1ffe1;
}
-->
</style>
</head>
<body>
<div id="page">
  <div id="logo">
    <a href=""><img src=""></a>
  </div><!--end logo-->
  
  <div id="address">

    <p>Your company name<br>
    <a href="mailto:youremail@somewhere.com">youremail@somewhere.com</a>
    <br><br>
    Transaction # xxx<br>
    Created on 2008-10-09<br>
    </p>
  </div><!--end address-->

  <div id="content">
    <p>
      <strong>Customer Details</strong><br>
      Name: {{isset($checkout_data['address']['name'])?$checkout_data['address']['name']:''}}<br>
      Email: {{isset($checkout_data['address']['email'])?$checkout_data['address']['email']:''}}<br>
      </p>
    <hr>
    <table>
      <tbody>
        <tr>
          <td>
            <strong>S. No.</strong>
          </td>
          <td>
            <strong>Particulars</strong>
          </td>
          <td>
            <strong>Quantity</strong>
          </td>
          <td>
            <strong>Item Base Price</strong>
          </td>
          <td>
            <strong>Option Extra Price</strong>
          </td>
          <td>
            <strong>Sub Total</strong>
          </td>
        </tr>

        @if(isset($checkout_data['items']['cart']))
            @foreach($checkout_data['items']['cart'] as $item_id => $item)
              @foreach($item as $option_id => $options_value)
                <tr class="even">
                    <td>{{$item_id}}/{{$option_id}}</td>
                    <td>{{$options_value['title']}}</td>
                    <td>{{$options_value['qty']}}</td>
                    <td>{{$checkout_data['items']['prices']['base_price']}}</td>
                    <td>{{$options_value['option_price']}}</td>
                    <td>{{$options_value['row_total']}}</td>
                </tr>
              @endforeach
            @endforeach
        @endif
             
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>
          <strong>Total</strong>
        </td>
        <td>
          <strong>{{isset($checkout_data['items']['prices']['total'])?$checkout_data['items']['prices']['total']:''}}</strong>
        </td>
      </tr>

    </tbody></table>
    <hr>
    <p>
      Thank you for your order!  This transaction will appear on your billing statement as "Your Company".<br>
      If you have any questions, please feel free to contact us at <a href="mailto:youremail@somewhere.com">youremail@somewhere.com</a>.
    </p>

    <hr>
    <p>
      </p><center><small>This communication is for the exclusive use of the addressee and may contain proprietary, confidential or privileged information. If you are not the intended recipient any use, copying, disclosure, dissemination or distribution is strictly prohibited.
      <br><br>
      © Your Company All Rights Reserved
      </small></center>
    <p></p>
  </div><!--end content-->
</div><!--end page-->


</body></html>