<table class="table table-responsive" id="sales-table">
    <thead>
        <tr>
        <th>ID</th>
        <th>Età</th>
        <!--<th>Tipo di pacchetto</th>-->
        <th>Prezzo</th>
        <!-- <th>Contraente Genere</th> -->
        <th>Contraente Nome</th>
        <th>Contraente Cognome</th>
        <!-- <th>Contraente Indirizzo</th>
        <th>Contraente Luogo</th>
        <th>Contraente Compleanno</th> -->
        <!--<th>Contraente luogo di nascita</th>-->
        <th>Contraente EMail</th>
        <!-- <th>Contraente Telefono</th> -->
        <!--
        <th>Assicurato Genere</th>
        <th>Assicurato Nome</th>
        <th>Assicurato Cognome</th>
        <th>Assicurato Indirizzo</th>
        <th>Assicurato Luogo</th>
        <th>Assicurato Compleanno</th>
        <th>Assicurato luogo di nascita</th>
        <th>Assicurato EMail</th>
        <th>Assicurato Telefono</th>

        <th>Beneficiario Caso Morte Genere</th>
        <th>Beneficiario Caso Morte Nome</th>
        <th>Beneficiario Caso Morte Cognome</th>
        <th>Beneficiario Caso Morte Indirizzo</th>
        <th>Beneficiario Caso Morte Luogo</th>
        <th>Beneficiario Caso Morte Compleanno</th>
        <th>Beneficiario luogo di nascita</th>
        <th>Beneficiario Caso Morte EMail</th>
        <th>Beneficiario Caso Morte Telefono</th>

        <th>Receiveemail</th>-->
        <th colspan="3">Azioni</th>
        </tr>
    </thead>
    <tbody>
    @foreach($sales as $sale)
        <tr>
            <?php $sale['personalInfo'] = unserialize($sale->personalInfo); ?>
            <td>{!! $sale->seller_id !!}</td>
            <td>{!! $sale->age !!}</td>
            <!--<td>{!! $sale->packageType !!}</td>-->
            <td>{!! $sale->price !!}</td>
            <!-- <td>{!! $sale->contractorType !!}</td> -->
            <td>{!! $sale->idd_first_name !!}</td>
            <td>{!! $sale->idd_last_name !!}</td>
            <!-- <td>{!! $sale->contractorAddress !!}</td>
            <td>{!! $sale->contractorTaxCode !!}</td>
            <td>{!! $sale->contractorBirthday !!}</td> -->
            <!--<td>{!! $sale->contractorBirthPlace !!}</td>-->
            <td>{!! $sale->idd_email !!}</td>
            <!-- <td>{!! $sale->contractorTelephone !!}</td> -->
            <!--
            <td>{!! $sale->insuredType !!}</td>
            <td>{!! $sale->insuredFirstName !!}</td>
            <td>{!! $sale->insuredLastName !!}</td>
            <td>{!! $sale->insuredAddress !!}</td>
            <td>{!! $sale->insuredTaxCode !!}</td>
            <td>{!! $sale->insuredBirthday !!}</td>
            <td>{!! $sale->insuredBirthPlace !!}</td>
            <td>{!! $sale->insuredEmail !!}</td>
            <td>{!! $sale->insuredTelephone !!}</td>
            <td>{!! $sale->deathBenType !!}</td>
            <td>{!! $sale->deathBenFirstName !!}</td>
            <td>{!! $sale->deathBenLastName !!}</td>
            <td>{!! $sale->deathBenAddress !!}</td>
            <td>{!! $sale->deathBenTaxCode !!}</td>
            <td>{!! $sale->deathBenBirthday !!}</td>
            <td>{!! $sale->deathBenBirthPlace !!}</td>
            <td>{!! $sale->deathBenEmail !!}</td>
            <td>{!! $sale->deathBenTelephone !!}</td>
            <td>{!! $sale->receiveEmail !!}</td>
            -->
            <td>
                {!! Form::open(['route' => ['admin.sales.destroy', $sale->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! '/download_document?sale_id='.$sale->id.'-1'; !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-download"></i></a>
                    <a href="{!! '/download_document?sale_id='.$sale->id.'-2'; !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-download"></i></a>
                    <a href="{!! '/download_document?sale_id='.$sale->id.'-3'; !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-download"></i></a>
                    <a href="{!! route('admin.sales.show', [$sale->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('admin.sales.edit', [$sale->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Sei sicuro?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
