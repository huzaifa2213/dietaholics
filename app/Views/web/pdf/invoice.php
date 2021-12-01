<html>

<body>
    <table border="0" cellpadding="40" align="center" width="100%" style="border-collapse: collapse;background-color:#eff0f2;border-spacing:0">

        <tr>
            <td>
                <table width="580px" style="background-color:#ffffff;border-collapse: collapse;border-spacing:0;vertical-align:top;" align="center" cellpadding="20">
                    <tr>
                        <td>
                            <table border="0" cellpadding="0" style="padding-bottom:20px;" width="100%">
                                <tr>
                                    <td style="text-align: right;">
                                        <img width="200px" src="<?=getImagePath($settings['website_logo'],''); ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;border-bottom:2px solid #333333">
                                        <p style="margin-top: 0px;color:#333333">Happiness is Homemade</p>
                                    </td>
                                </tr>
                            </table>
                            <table border="0" cellpadding="0" width="100%" style="padding-bottom:20px;">

                                <tr>
                                    <td>
                                        <h3 style="color: #333333;background-color: #0a9822;margin:0;padding:10px">Thanks for your order.</h3>
                                    </td>
                                </tr>
                               

                                <tr>
                                    <td style="text-align: center;"><a href="<?= base_url('my-orders') ?>" style="background-color: #0a9822; color:#ffffff; height:35px; padding: 0px 40px; border-radius:30px;    text-decoration: none;line-height: 35px;display: inline-block;">Track Your Order</a></td>
                                </tr>

                            </table>

                            <table border="0" cellpadding="5px" width="100%" style="padding-bottom:20px;">

                                <tr>
                                    <td>
                                        <h3 style="margin: 0;">Your Reciept #F-<?= str_pad($orderInfo['id'], 5, '0', STR_PAD_LEFT) ?></h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b><?= $orderInfo['name'] ?></b>(<?= $orderInfo['address']?>)</td>
                                </tr>
                                <tr>
                                    <td>Email: <?= $orderInfo['r_email'] ?></td>
                                </tr>
                                <tr>
                                    <td>Phone: <?= $orderInfo['r_phone'] ?></td>
                                </tr>

                            </table>

                            
                                <table border="0" cellpadding="0" width="100%" style="margin-bottom:10px;border-collapse:collapse; border-top:3px solid #0a9822">
                                   
                                    <?php
                                   
                                        foreach ($orderInfo['products'] as $d) { ?>
                                            <tr>
                                                <td><?= $d['product_quantity'] ?> X <?= $d['product_name'] ?></td>
                                                <td style="text-align: right;"><?= CURRENCY . numberFormat($d['product_quantity'] * $d['product_price']) ?></td>
                                            </tr>
                                            
                                    <?php    }
                                    ?>
                                    

                                </table>
                            
                            <table border="0" cellpadding="0" width="100%" style="margin-bottom:10px;border-collapse:collapse;border-top:3px solid #0a9822">
                                <tr>
                                    <td style="padding-top: 10px;">Sub Total</td>
                                    <td style="text-align: right;padding-top: 10px;"><b><?= CURRENCY . numberFormat($orderInfo['grand_total'] - $orderInfo['tip_price'] - $orderInfo['discount_price']  - $orderInfo['admin_charge']) ?></b></td>
                                </tr>
                                <tr>
                                    <td>Voucher Discount</td>
                                    <td style="text-align: right;"><b><?= CURRENCY . $orderInfo['discount_price']  ?></b></td>
                                </tr>
                                <tr>
                                    <td>Platform Fee</td>
                                    <td style="text-align: right;"><b><?= CURRENCY . $orderInfo['admin_charge']  ?></b></td>
                                </tr>
                                <tr>
                                    <td>Tip Price</td>
                                    <td style="text-align: right;"><b><?= CURRENCY . $orderInfo['tip_price']  ?></b></td>
                                </tr>
                                <tr style="border-top:3px solid #0a9822">
                                    <td style="padding-top: 10px;"><b>Grand Total</b></td>
                                    <td style="text-align: right; padding-top: 10px;"><b><?= CURRENCY . $orderInfo['total_price']  ?></b></td>
                                </tr>

                            </table>
                            <table border="0" cellpadding="0" width="100%" style="border-top: 2px solid #333333;padding-top: 15px;
">

                                <tr>
                                    <td>Thanks and Regards,</td>
                                </tr>
                                <tr>
                                    <td><strong><?= $settings['website_name'] ?></strong></td>
                                </tr>

                            </table>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
</body>

</html>