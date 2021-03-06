<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8" />
        <title>{{{ empty($payslip['title']) ? (empty($drawer['name']) ? $cedant['name'] : $drawer['name']) : $payslip['title'] }}}</title>
        <style type="text/css">
            @media print { .no-print { display: none !important; } }
            .no-border { border-width: 0px !important; }
            .no-margin { margin: 0px !important; }
            .height-53px { height: 53px !important; }
            .height-81px { height: 81px !important; }
            .height-108px { height: 108px !important; }
            .height-139px { height: 139px !important; }
            .right-align { text-align: right; }

            div.boleto { color: black; font-family: Arial; font-size: 10px; width: 665px; margin: 0px auto; }
            div.boleto hr { color: white; border-color: black; border-width: 1px; border-style: none none dashed; margin: 0px; }
            div.boleto img { vertical-align: bottom; }

            div.boleto .row { font-size: 0px; clear: both; position: relative; height: 27px; border-right: 1px solid #000033; }
            div.boleto .row.first { border-right-width: 0px; border-bottom-width: 2px; padding-top: 3em; height: auto; }
            div.boleto .row, div.cell.calculation div.cell { border-bottom: 1px solid #000033; }
            div.cell.calculation div.cell { border-left-width: 0px; width: 191px; }
            div.boleto .cell { font-size: 10px; overflow: hidden; border-left: 1px solid #000033; height: 27px; display: inline-block; vertical-align: top; }
            div.boleto .cell p { margin: 0px; padding: 0px 5px 2px 7px; }
            div.boleto .cell p.label { color: #000033; padding-bottom: 0px; }
            div.boleto .cell p.label.description { margin-bottom: 3px; margin-top: 2px; }
            div.boleto .cell p.label.auth { padding: 2px 0px; font-size: 8px; text-align: right; }
            div.boleto .cell p.value { font-weight: bold; }
            div.boleto .cell p.value.barcode { padding-top: 5px; }
            div.boleto .cell span.value { font-weight: bold; color: black; }
            div.boleto .cut-line { clear: both; color: #000033; padding-bottom: 0px; margin-bottom: 0px; text-align: right; }

            span.bank-code { font-size: 20px; font-weight: bold; border: solid #000033; border-width: 0px 2px; padding: 0px 5px; margin-left: 3px; }
            div.typable-line { font-size: 15px; font-weight: bold; position: absolute; right: 1px; bottom: 0px; }
            div.vertical-spacer { clear: both; height: 2em; }

            div.instructions { font-weight: bold; margin-bottom: 2em; }
            div.instructions .header { text-align: center; }
            div.instructions .details { margin: 2px 0px 2px 3.3em; font-size: 12px; }

            div.receipt .header { font-weight: bold; text-align: right; margin: 0px; }
            div.receipt img.logo { border: 0px; float: left; margin: 0px 1.5em 0px 0.5em; }
            div.receipt p.drawer { display: inline-block; margin: 0px; }
         </style>
    </head>

    <body>

        <div class="boleto">

            <div class="instructions no-print">
                <p class="header">Instruções de Impressão</p>
                <ul class="items">
                    <li>Imprima em impressora jato de tinta (ink jet) ou laser em qualidade normal ou alta (Não use modo econômico).</li>
                    <li>Utilize folha A4 (210 x 297 mm) ou Carta (216 x 279 mm) e margens mínimas à esquerda e à direita do formulário.</li>
                    <li>Corte na linha indicada. Não rasure, risque, fure ou dobre a região onde se encontra o código de barras.</li>
                    <li>Caso não apareça o código de barras no final, clique em F5 para atualizar esta tela. </li>
                    <li>Caso tenha problemas ao imprimir, copie a seqüencia numérica abaixo e pague no caixa eletrônico ou no internet banking:</li>
                </ul>
                <p class="details">Linha Digitável: {{{ $payslip['typable_line'] }}}</p>
                <p class="details">Valor: {{{ $payslip['currency'] }}} {{{ $payslip['value'] }}}</p>
            </div> <!-- end instructions -->

            <hr />

            <div class="receipt">
                <p class="header">Recibo do Sacado</p>

                @if($paths['logo_drawer']) <img class="logo" src="{{{ URL::asset($paths['logo_drawer']) }}}" /> @endif
                <p class="drawer">
                    @if($drawer['name']) {{{ $drawer['name'] }}}<br />@endif
                    @if($drawer['cpf_cnpj']) {{{ format_cpf_cnpj($drawer['cpf_cnpj']) }}}<br />@endif
                    @if($drawer['address_line1']) {{{ $drawer['address_line1'] }}}<br />@endif
                    {{{ $drawer['address_line2'] }}}
                </p>

                <div class="vertical-spacer"></div>

                <div class="first row">
                    <img src="{{{ URL::asset($paths['logo_cedant_bank']) }}}" />
                    <span class="bank-code">{{{ $cedant['bank_code'] }}}</span>
                    <div class="typable-line">{{{ $payslip['typable_line'] }}}</div>
                </div>
                <div class="row">
                    <div class="cell" style="width: 270px">
                        <p class="label">Cedente</p>
                        <p class="value">{{{ $cedant['name'] }}}</p>
                    </div>
                    <div class="cell" style="width: 146px">
                        <p class="label">Agência/Código do Cedente</p>
                        <p class="value">{{{ $cedant['branch'] }}} / {{{ $cedant['code'] }}}</p>
                    </div>
                    <div class="cell" style="width: 51px">
                        <p class="label">Espécie</p>
                        <p class="value">{{{ $payslip['currency'] }}}</p>
                    </div>
                    <div class="cell" style="width: 67px">
                        <p class="label">Quantidade</p>
                        <p class="value">{{-- $payslip['quantity'] --}}</p>
                    </div>
                    <div class="cell" style="width: 123px">
                        <p class="label">Nosso número</p>
                        <p class="value">{{{ $payslip['our_number'] }}}</p>
                    </div>
                </div> <!-- end row-->
                <div class="row">
                    <div class="cell" style="width: 193px">
                        <p class="label">Número do Documento</p>
                        <p class="value">{{{ $payslip['document_number'] }}}</p>
                    </div>
                    <div class="cell" style="width: 137px">
                        <p class="label">CPF/CNPJ</p>
                        <p class="value">{{{ format_cpf_cnpj($cedant['cpf_cnpj']) }}}</p>
                    </div>
                    <div class="cell" style="width: 137px">
                        <p class="label">Vencimento</p>
                        <p class="value">{{{ empty($payslip['due_date']) ? 'Contra Apresentação' : $payslip['due_date'] }}}</p>
                    </div>
                    <div class="cell" style="width: 191px">
                        <p class="label">Valor documento</p>
                        <p class="value right-align">{{{ $payslip['value'] }}}</p>
                    </div>
                </div> <!-- end row-->
                <div class="row">
                    <div class="cell" style="width: 136px">
                        <p class="label">(-) Desconto / Abatimentos</p>
                        <p class="value right-align">{{-- $payslip['discount_value'] --}}</p>
                    </div>
                    <div class="cell" style="width: 108px">
                        <p class="label">(-) Outras deduções</p>
                        <p class="value right-align">{{-- $payslip['deductions_value'] --}}</p>
                    </div>
                    <div class="cell" style="width: 108px">
                        <p class="label">(+) Mora / Multa</p>
                        <p class="value right-align">{{-- $payslip['forfeit_value'] --}}</p>
                    </div>
                    <div class="cell" style="width: 114px">
                        <p class="label">(+) Outros acréscimos</p>
                        <p class="value right-align">{{-- $payslip['affix_value'] --}}</p>
                    </div>
                    <div class="cell" style="width: 191px">
                        <p class="label">(=) Valor cobrado</p>
                        <p class="value right-align">{{-- $payslip['final_value'] --}}</p>
                    </div>
                </div> <!-- end row-->
                <div class="row">
                    <div class="cell" style="width: 655px">
                        <p class="label">Sacado</p>
                        <p class="value">{{{ $payer['name'] }}}</p>
                    </div>
                </div> <!-- end row --> 
                <div class="row no-border height-108px">
                    <div class="cell no-border height-108px" style="width: 576px">
                        <p class="label description">Demonstrativo</p>
                        <p class="value">{{ nl2br(e($payslip['description'])) }}</p>
                    </div>
                    <div class="cell no-border height-108px" style="width: 81px">
                        <p class="label auth">Autenticação mecânica</p>
                    </div>
                </div> <!-- end row -->
            </div> <!-- end receipt-->

            <p class="cut-line">Corte na linha pontilhada</p>
            <hr />

            <div class="compensation">

                <div class="vertical-spacer"></div>

                <div class="first row">
                    <img src="{{{ URL::asset($paths['logo_cedant_bank']) }}}" />
                    <span class="bank-code">{{{ $cedant['bank_code'] }}}</span>
                    <div class="typable-line">{{{ $payslip['typable_line'] }}}</div>
                </div>
                <div class="row">
                    <div class="cell" style="width: 469px">
                        <p class="label">Local de pagamento</p>
                        <p class="value">{{{ $payslip['payment_location'] }}}</p>
                    </div>
                    <div class="cell" style="width: 191px">
                        <p class="label">Vencimento</p>
                        <p class="value right-align">{{{ empty($payslip['due_date']) ? 'Contra Apresentação' : $payslip['due_date'] }}}</p>
                    </div>
                </div> <!-- end row-->
                <div class="row">
                    <div class="cell" style="width: 469px">
                        <p class="label">Cedente</p>
                        <p class="value">{{{ $cedant['name'] }}}</p>
                    </div>
                    <div class="cell" style="width: 191px">
                        <p class="label">Agência/Código cedente</p>
                        <p class="value right-align">{{{ $cedant['branch'] }}} / {{{ $cedant['code'] }}}</p>
                    </div>
                </div> <!-- end row-->
                <div class="row">
                    <div class="cell" style="width: 115px">
                        <p class="label">Data do documento</p>
                        <p class="value">{{{ $payslip['document_date'] }}}</p>
                    </div>
                    <div class="cell" style="width: 125px">
                        <p class="label">Nº documento</p>
                        <p class="value">{{{ $payslip['document_number'] }}}</p>
                    </div>
                    <div class="cell" style="width: 73px">
                        <p class="label">Espécie doc.</p>
                        <p class="value">{{{ $payslip['document_type'] }}}</p>
                    </div>
                    <div class="cell" style="width: 42px">
                        <p class="label">Aceite</p>
                        <p class="value">{{{ $payslip['acceptance'] }}}</p>
                    </div>
                    <div class="cell" style="width: 110px">
                        <p class="label">Data processamento</p>
                        <p class="value">{{{ $payslip['rendering_date'] }}}</p>
                    </div>
                    <div class="cell" style="width: 190px">
                        <p class="label">Nosso número</p>
                        <p class="value right-align">{{{ $payslip['our_number'] }}}</p>
                    </div>
                </div> <!-- end row-->
                <div class="row">
                    <div class="cell" style="width: 115px">
                        <p class="label">Uso do banco</p>
                    </div>
                    <div class="cell" style="width: 74px">
                        <p class="label">Carteira</p>
                        <p class="value">{{{ $payslip['wallet'] }}}</p>
                    </div>
                    <div class="cell" style="width: 51px">
                        <p class="label">Espécie</p>
                        <p class="value">{{{ $payslip['currency'] }}}</p>
                    </div>
                    <div class="cell" style="width: 115px">
                        <p class="label">Quantidade</p>
                        <p class="value">{{-- $payslip['quantity'] --}}</p>
                    </div>
                    <div class="cell" style="width: 110px">
                        <p class="label">Valor Documento</p>
                        <p class="value">{{-- $payslip['value'] --}}</p>
                    </div>
                    <div class="cell" style="width: 190px">
                        <p class="label">(=) Valor documento</p>
                        <p class="value right-align">{{{ $payslip['value'] }}}</p>
                    </div>
                </div> <!-- end row-->
                <div class="row height-139px">
                    <div class="cell height-139px" style="width: 469px">
                        <p class="label">Instruções (Texto de responsabilidade do cedente)</p>
                        <p class="value"><br />{{ nl2br(e($payslip['instructions'])) }}</p>
                    </div>
                    <div class="cell height-139px calculation" style="width: 191px">
                        <div class="cell">
                            <p class="label">(-) Desconto / Abatimentos</p>
                            <p class="value right-align">{{-- $payslip['discount_value'] --}}</p>
                        </div>
                        <div class="cell">
                            <p class="label">(-) Outras deduções</p>
                            <p class="value right-align">{{-- $payslip['deductions_value'] --}}</p>
                        </div>
                        <div class="cell">
                            <p class="label">(+) Mora / Multa</p>
                            <p class="value right-align">{{-- $payslip['forfeit_value'] --}}</p>
                        </div>
                        <div class="cell">
                            <p class="label">(+) Outros acréscimos</p>
                            <p class="value right-align">{{-- $payslip['affix_value'] --}}</p>
                        </div>
                        <div class="cell">
                            <p class="label">(=) Valor cobrado</p>
                            <p class="value right-align">{{-- $payslip['final_value'] --}}</p>
                        </div>
                    </div>
                </div> <!-- end row-->
                <div class="row height-53px">
                    <div class="cell height-53px" style="width: 469px">
                        <p class="label">Sacado</p>
                        <p class="value">
                            {{{ $payer['name'] }}}{{{ $payer['cpf_cnpj'] ? ' - CPF/CNPJ: ' : '' }}}{{{ format_cpf_cnpj($payer['cpf_cnpj']) }}}<br />
                            {{{ $payer['address_line1'] }}}<br />
                            {{{ $payer['address_line2'] }}}
                        </p>
                    </div>
                    <div class="cell height-53px" style="width: 191px">
                        <p class="label" style="margin-top: 40px">Cód. baixa</p>
                    </div>
                </div> <!-- end row-->
                <div class="row no-border height-81px">
                    <div class="cell no-border height-81px" style="width: 420px">
                        <p class="label">
                            Sacador/Avalista<br />
                            <span class="value">{{{ $drawer['name'] }}}</span>
                            &nbsp; {{{ $drawer['cpf_cnpj'] ? 'CPF/CNPJ:' : '' }}}
                            <span class="value">{{{ format_cpf_cnpj($drawer['cpf_cnpj']) }}}</span>
                        </p>
                        <p class="value barcode">{{ draw_bar_code($payslip['bar_code']) }}</p>
                    </div>
                    <div class="cell no-border height-81px" style="width: 245px">
                        <p class="label">
                            Autenticação mecânica - 
                            <span class="value">Ficha de Compensação</span>
                        </p>
                    </div>
                </div> <!-- end row -->
            </div> <!-- end compensation -->

            <p class="cut-line no-margin">Corte na linha pontilhada</p>
            <hr />

        </div> <!-- end boleto-->

        <div class="vertical-spacer no-print"></div>

    </body>

    </html>
