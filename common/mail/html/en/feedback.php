<div style="font:14px sans-serif">
    <h1 style="padding: 10px 0; text-align: center;">
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
</div>