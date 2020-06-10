<table width="100%" cellspacing="0" border="0">
    <tbody>
        <tr>
            <td></td>
            <td style="font:14px sans-serif" width="600">
                <h1 style="background: #337ab7; color: #fff; padding: 10px 0; text-align: center; border-radius: 5px;">
                    Feedback
                </h1>
                
                <table style="width: 100%; border-collapse: collapse;">
                    <tbody>
                        <?php foreach ($data as $d) { ?>
                            <tr>
                                <td style="border: 1px #333 solid; padding: 5px;">
                                    <?= $d['label'] ?>
                                </td>
                                <td style="border: 1px #333 solid; padding: 5px;">
                                    <?= nl2br($d['value']) ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </td>
            <td></td>
        </tr>
    </tbody>
</table>