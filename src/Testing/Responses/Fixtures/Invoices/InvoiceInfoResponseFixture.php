<?php

declare(strict_types=1);

namespace EFinancialsClient\Testing\Responses\Fixtures\Invoices;

/**
 * OpenAPI `CompanyInvoiceInfo` schema example (fuller projection).
 *
 * @see https://rmp-api.rik.ee/openapi.yaml
 */
final class InvoiceInfoResponseFixture
{
    /**
     * @var array<string, mixed>
     */
    public const ATTRIBUTES = [
        'address' => 'Tõru tn 144, Pirita linnaosa, Tallinn, Harju maakond, 12011',
        'email' => 'test@mail.ee',
        'phone' => '58012345',
        'fax' => '123123123',
        'webpage' => 'www.ee',
        'cl_templates_id' => 1,
        'invoice_company_name' => null,
        'invoice_email_subject' => 'Arve $arve_nr$ ($ettevotja_nimetus$) ${kala}',
        'invoice_email_body' => 'Teile on $ettevotja_nimetus$ poolt loodud arve. ${kala}',
        'balance_email_subject' => '$ettevotja_nimetus$ saldokinnitus ($bilansipaev$) ${kala}',
        'balance_email_body' => 'Teile on $ettevotja_nimetus$ poolt saadetud saldokinnituse dokument. Ootame Teie poolset vastust hiljemalt $tahtaeg10$. Juhul, kui me selleks ajaks vastust ei ole saanud, loeme meiepoolse saldo kinnitatuks.\n${kala}',
        'balance_document_footer' => 'Ootame Teie vastust hiljemalt $tahtaeg10$ ettevõtte meiliaadressile $epost_arvel$ või postiga aadressile $aadress_arvel$. Juhul, kui me selleks ajaks vastust ei ole saanud, loeme meiepoolse saldo kinnitatuks.\nLugupidamisega $saatja_nimi$ ${kala}',
    ];
}
