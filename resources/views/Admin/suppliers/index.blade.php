<!--...........................................BARRA SUPERIOR.................................................-->
@extends('Admin.layouts.app')
<!--...........................................CONTEUDO DO CORPO.................................................-->

@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/styles/metro/notify-metro.css">

<style type="text/css">
    .pagination li {
        display: inline-block;
        padding: 5px;
    }

    .notifyjs-corner {
        top: 20% !important;
        right: 45% !important;
    }
</style>

@endpush


@push('javascript')
<script type="text/javascript" src="{{ URL::asset('Admin/js/node_modules/printthis/printThis.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('Admin/js/suppliers.js') }}"></script>

<script>
    window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
</script>
@endpush
<!--Suppliers JS functions -->

@section('content')

<div class="w3-container" id="page">

    <div class="w3-row">
      <div class="w3-col-10">
        <button class="w3-right btn btn-blue btn-pill" id="" onclick="suppliercreate()" style="color:teal; font-size:13px;">
          <b>New</b>
        </button>
      </div>
    </div>

    <div class="w3-row">
        <div class="w3-col l4">
            <h1>Suppliers</h1>
        </div>
        {!! Form::open([ 'class'=>'w3-col l7']) !!}
          <div class="w3-section">
              {!! Form::text('Destination', null, ['id'=>'procura', 'class'=>'w3-input w3-border w3-margin-bottom', 'placeholder'=>'Search', 'onkeyup'=>'search()']) !!}
          </div>
        {!! Form::close() !!}
    </div>

    <!--........................................FOR EACH E INICIO DA TABELA...............................................-->
    <div id="supp"></div>
    @foreach($suppliers as $supplier)

    <!--................................................PROFILE.................................................-->
    <div id="divsup{{ $supplier->id }}" class="w3-padding-16">
        <div class=" w3-container">
            <table class="w3-table  w3-border-top w3-border-right w3-border-left  w3-striped">

                <tbody>
                    <tr>
                        <td>
                            <a title="Delete" href="{{ route('suppliers.destroy',['id'=>$supplier->id]) }}" onclick="if (! confirm('Continue?')) { return false; }" class="w3-button fa fa-eraser w3-right" style="color:teal" aria-hidden="true"></a>

                            <a title="Edit" onclick="supplieredit({{ $supplier->id }})" class="w3-button fa fa-pencil-square-o w3-right" style="color:teal" aria-hidden="true"></a>

                            <a title="Print" onclick="PrintElem({{ $supplier->id }})" class="w3-button fa fa-print w3-right" style="color:teal" aria-hidden="true"></a>

                            <div class=" w3-container">

                                <div class="row">
                                    <div class="col-lg-3 col-md-3">
                                        @if(config('app.env') != 'local')
                                            <img style="width:152px;" class="w3-card-4"  src="<?php echo asset("storage/$supplier->path_image")?>">
                                        @else
                                            <img style="width:152px;" class="w3-card-4" src="https://atsportugal.com/public/storage/{{$supplier->path_image}}">
                                        @endif
                                        <br>
                                        <label style="text-align:left!important; font-size: 26px; font-weight:400; margin-top:8px; word-wrap:break-word;">{{ $supplier->name }}</label>
                                    </div>

                                    <div class="col-lg-9 col-md-9">

                                        <div class="w3-row ">
                                            <div class="w3-col w3-right-align" style="width:20%;">
                                                <b class="w3-text-teal">Social Denomination: </b>
                                            </div>
                                            <div class="w3-col" style="width:400px; margin-left: 40px;">
                                                {{ $supplier->social_denomination }}
                                            </div>
                                        </div>

                                        <div class="w3-row">
                                            <div class="w3-col w3-right-align" style="width:20%;">
                                                <b class="w3-text-teal" style="">NIF: </b>
                                            </div>
                                            <div class="w3-col" style="width:400px; margin-left: 40px;">
                                                {{ $supplier->fiscal_number }}
                                            </div>
                                        </div>

                                        <div class="w3-row">
                                            <div class="w3-col w3-right-align" style="width:20%; ">
                                                <b class="w3-text-teal">Web Address: </b>
                                            </div>
                                            <div class="w3-col" style="width:400px; margin-left: 40px;">
                                                <a href="http://{{ $supplier->web }}">{{ $supplier->web }}</a>
                                            </div>
                                        </div>

                                        <div class="w3-row">
                                            <div class="w3-col w3-right-align" style="width:20%; ">
                                                <b class="w3-text-teal">Remarks: </b>
                                            </div>
                                            <div class="w3-col" style="word-break: break-all; width:460px; margin-left: 40px;">{{ $supplier->remarks }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </td>
                    </tr>

                </tbody>

            </table>

            <!--................................................BANCO.................................................-->

            <div class="w3-border-top w3-border-right w3-border-left w3-accordion-content prod-det-cont  w3-container w3-padding-16 w3-light-grey w3-border-black"><b>Bank Accounts</b>
                <i id="bank{{ $supplier->id }}" onclick="bank({{ $supplier->id }})" class="fa fa-plus w3-right w3-button" style="font-size:18px"></i>
                <div id="myDIVbank{{ $supplier->id }}" style="display: none;">

                </div>
            </div>

            <!--................................................CONTATOS.................................................-->

            <div colspan="5" class="w3-padding-16 w3-accordion-content prod-det-cont  w3-container w3-border-top w3-border-right w3-border-left w3-text-black w3-border-black"><b>Contacts</b> <i id="contact{{ $supplier->id }}" onclick="contato({{ $supplier->id }})" class="fa fa-plus w3-right w3-button" style="font-size:18px"></i>
                <div id="myDIVcontact{{ $supplier->id }}" style="display: none;">
                    <br/>

                    <table width="100%">
                        <tbody>
                            <th class="w3-border w3-border-teal ">
                                Contracts

                                <a title="Create Contracts" class="w3-right w3-button" onclick="createcontact({{ $supplier->id }},'Contracts')"><i style="color:teal" class="fa fa-plus-circle w3-right" aria-hidden="true"></i></a>
                                <a title="Edit Contracts" onclick="contactedit({{ $supplier->id }},'Contracts')" class="fa fa-pencil-square-o w3-right w3-button" style="color:teal" aria-hidden="true"></a>

                            </th>
                        </tbody>
                    </table>

                    <div class="w3-responsive">
                        <table id="tablecontracts{{ $supplier->id }}" class="table table-striped table-bordered table-hover w3-animate-opacity w3-table-all">
                        </table>
                    </div>

                    <br/>

                    <table width="100%">
                        <tbody>
                            <th class="w3-border w3-border-teal ">
                                Reservations

                                <a title="Create Reservations" class="w3-right w3-button" onclick="createcontact({{ $supplier->id }},'Reservations')"><i style="color:teal" class="fa fa-plus-circle w3-right" aria-hidden="true"></i></a>
                                <a title="Edit Reservations" onclick="contactedit({{ $supplier->id }},'Reservations')" class="fa fa-pencil-square-o w3-right w3-button" style="color:teal" aria-hidden="true"></a>

                            </th>
                        </tbody>
                    </table>

                    <div class="w3-responsive">
                        <table id="tablereservations{{ $supplier->id }}" class="table table-striped table-bordered table-hover w3-animate-opacity w3-table-all">
                        </table>
                    </div>

                    <br/>

                    <table width="100%">
                        <tbody>
                            <th class="w3-border w3-border-teal ">
                                Accounts

                                <a title="Create Accounts" class="w3-right w3-button" onclick="createcontact({{ $supplier->id }},'Accounts')"><i style="color:teal" class="fa fa-plus-circle w3-right" aria-hidden="true"></i></a>
                                <a title="Edit Accounts" onclick="contactedit({{ $supplier->id }},'Accounts')" class="fa fa-pencil-square-o w3-right w3-button" style="color:teal" aria-hidden="true"></a>

                            </th>
                        </tbody>
                    </table>

                    <div class="w3-responsive">
                        <table id="tableaccounts{{ $supplier->id }}" class="table table-striped table-bordered table-hover w3-animate-opacity w3-table-all">
                        </table>
                    </div>

                </div>

            </div>
            <!--................................................LOCAL.................................................-->

            <div colspan="5" class="w3-light-grey w3-padding-16 w3-border w3-accordion-content prod-det-cont  w3-container w3-border-black"><b>Locations</b> <i id="location{{ $supplier->id }}" onclick="loca({{ $supplier->id }})" class="fa fa-plus w3-right w3-button" style="font-size:18px"></i>
                <div id="myDIVlocation{{ $supplier->id }}" style="display: none; overflow-y: auto;">

                </div>
            </div>

        </div>

    </div>

    <div id="editSupplier{{ $supplier->id }}" class="w3-modal w3-animate-opacity">
        <div class="w3-modal-content w3-card-4 w3-animate-opacity w3-display-topmiddle" style="max-width:1200px">

            <div class="w3-center">
                <br>
                <span onclick="closeModal('editSupplier{{ $supplier->id }}','editSupplier_form{{ $supplier->id }}','editSupplier_img{{ $supplier->id }}','error{{ $supplier->id }}','{{ $supplier->path_image }}')" class="w3-button w3-xlarge w3-red w3-hover-red w3-display-topright" title="Close Modal">&times;</span>

            </div>

            <h5 class="w3-center"><b>Edit Supplier</b></h5>

            {!! Form::open(['files' => true, 'class'=>'w3-container', 'id'=>"editSupplier_form$supplier->id"]) !!}

            <div class="w3-section">

                {{Form::label('Imagem', 'Image',['class' => 'control-label'])}}

                <div class="w3-cell-row w3-margin-bottom">
                    <div class="w3-container w3-section w3-cell w3-margin-bottom">

                        @if(config('app.env') != 'local')
                            <img class="w3-card-4 w3-margin-bottom" style="width:272px;" id="editSupplier_img{{ $supplier->id }}" src="<?php echo asset("storage/$supplier->path_image")?>">
                        @else
                            <img class="w3-card-4 w3-margin-bottom" style="width:272px;" id="editSupplier_img{{ $supplier->id }}" src="https://atsportugal.com/public/storage/{{$supplier->path_image}}">
                        @endif

                    </div>
                    <div class="w3-container w3-section w3-cell w3-margin-bottom" id="error{{ $supplier->id }}"></div>
                </div>

                <div class="w3-cell-row w3-margin-top">

                    <div class="w3-container w3-cell w3-margin-top">
                        <!-- Nome Form Input -->
                        <div class="form-group">

                            {{Form::file('path_image',['id'=>"path_image$supplier->id",'onchange'=>"readURL(this,'#editSupplier_img$supplier->id')"])}}
                        </div>
                        <div class="form-group">
                            {!! Form::label('name', 'Name:') !!} {!! Form::text('name', $supplier->name, ['id'=>"name$supplier->id",'class'=>'w3-input w3-border', 'style'=>'padding: 3px 5px;']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('social_denomination', 'Social Denomination:') !!} {!! Form::text('social_denomination', $supplier->social_denomination, ['id'=>"social_denomination$supplier->id",'class'=>'w3-input w3-border', 'style'=>'padding: 3px 5px;']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('fiscal_number', 'Fiscal Number:') !!} {!! Form::text('fiscal_number', $supplier->fiscal_number, ['id'=>"fiscal_number$supplier->id",'class'=>'w3-input w3-border', 'style'=>'padding: 3px 5px;']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('web', 'Web:') !!} {!! Form::text('web', $supplier->web, ['id'=>"web$supplier->id",'class'=>'w3-input w3-border', 'style'=>'padding: 3px 5px;']) !!}
                        </div>

                    </div>

                    <div class="w3-container w3-cell w3-margin-top">
                        <div class="form-group ">
                            {!! Form::label('remarks', 'Remarks:') !!} {!! Form::textarea('remarks', $supplier->remarks, ['id'=>"remarks$supplier->id",'class'=>'w3-input w3-border', 'style'=>' height: 300px; resize: none;']) !!}
                        </div>

                    </div>

                </div>
                <div class="w3-cell-row">
                    <div class="w3-container w3-cell">
                        {!! Form::submit('&nbsp;&nbsp;Save&nbsp;&nbsp;', ['class'=>'w3-button w3-block w3-blue w3-section w3-padding']) !!}
                    </div>
                    <div class="w3-container w3-cell">
                        {!! Form::button('Cancel', ['class'=>'w3-button w3-block w3-red w3-section w3-padding', 'onclick'=>"closeModal('editSupplier$supplier->id','editSupplier_form$supplier->id','editSupplier_img$supplier->id','error$supplier->id','$supplier->path_image')"]) !!}
                    </div>
                </div>
            </div>
            {!! Form::close() !!}

        </div>
    </div>
    <!--................................................FIM DO FOREACH........................................-->
    @endforeach
    <!--......................................................................................................-->

    <!--................................................MODAL.................................................-->

    <div id="bankcreatedestiny" class="w3-modal w3-animate-opacity">
        <div class="w3-modal-content w3-card-4 w3-animate-opacity" style="max-width:600px">

            <div class="w3-center">
                <br>
                <span onclick="document.getElementById('bankcreatedestiny').style.display='none'; $('#bankcreatedestinyerror').empty();" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>

            </div>
            <h5 class="w3-center"><b>New Destination</b></h5>

            <div class="w3-container w3-section w3-cell w3-margin-bottom w3-center" id="bankcreatedestinyerror"></div>

            {!! Form::open([ 'class'=>'w3-container']) !!}
            <div class="w3-section">
                {!! Form::label('destination', 'Destination:') !!} {!! Form::text('Destination', null, ['id'=>'destination', 'class'=>'w3-input w3-border w3-margin-bottom']) !!} {!! Form::submit('Create', ['class'=>'w3-button w3-block w3-green w3-section w3-padding']) !!}
            </div>
            {!! Form::close() !!}

            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">

            </div>

        </div>
    </div>

    <!--................................................MODAL.................................................-->

    <div id="bankeditdestination" class="w3-modal w3-animate-opacity">
        <div class="w3-modal-content w3-card-4 w3-animate-opacity" style="max-width:600px">

            <div class="w3-center">
                <br>
                <span onclick="document.getElementById('bankeditdestination').style.display='none'; $('#bankediterror').empty();" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>

            </div>
            <h5 class="w3-center"><b>Edit Bank</b></h5>

            <div class="w3-container w3-section w3-cell w3-margin-bottom" id="bankediterror"></div>

            <div class="w3-section">
                <form id="bankeditdestinationform" class="w3-container">
                </form>
            </div>
            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">

            </div>

        </div>
    </div>

    <!--................................................MODAL.................................................-->

    <div id="bankcreateaccount" class="w3-modal w3-animate-opacity">
        <div class="w3-modal-content w3-card-4 w3-animate-opacity" style="max-width:600px">

            <div class="w3-center">
                <br>
                <span onclick="document.getElementById('bankcreateaccount').style.display='none'; $('#bankcreateerror').empty();" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>

            </div>

            <h5 class="w3-center"><b>Create Bank</b></h5>

            <div class="w3-container w3-section w3-cell w3-margin-bottom w3-center" id="bankcreateerror"></div>

            {!! Form::open([ 'class'=>'w3-container']) !!}
            <div class="w3-section">
                {!! Form::label('type', 'Type:') !!} {{ Form::select('Type', ['IBAN'=>'IBAN', 'SWIFT'=>'SWIFT', 'NIB'=>'NIB'], null,['id'=>'type', 'class'=>'w3-select w3-border w3-margin-bottom']) }} {!! Form::label('account number', 'Account Number:') !!} {!! Form::text('Account Number', null, ['id'=>'account_number', 'class'=>'w3-input w3-border w3-margin-bottom']) !!} {!! Form::submit('Create', ['class'=>'w3-button w3-block w3-green w3-section w3-padding']) !!}
            </div>
            {!! Form::close() !!}

            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">

            </div>

        </div>
    </div>

    <!--................................................MODAL.................................................-->

    <div id="createcontact" class="w3-modal w3-animate-opacity">
        <div class="w3-modal-content w3-card-4 w3-animate-opacity" style="max-width:600px">

            <div class="w3-center">
                <br>
                <span onclick="document.getElementById('createcontact').style.display='none'; $('#contactcreateerror').empty();" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>

            </div>
            <div id="contactCreateModalTitle"></div>
            <div class="w3-container w3-section w3-cell w3-margin-bottom" id="contactcreateerror"></div>

            {!! Form::open([ 'class'=>'w3-container']) !!}
            <div class="w3-section">

                {!! Form::label('name', 'Name:') !!} {!! Form::text('Name', null, ['id'=>'name', 'class'=>'w3-input w3-border w3-margin-bottom']) !!} {!! Form::label('phone', 'Phone:') !!} {!! Form::text('Phone', null, ['id'=>'phone', 'class'=>'w3-input w3-border w3-margin-bottom']) !!} {!! Form::label('e-mail', 'E-mail:') !!} {!! Form::text('E-mail', null, ['id'=>'email', 'class'=>'w3-input w3-border w3-margin-bottom']) !!} {!! Form::label('mobile', 'Mobile:') !!} {!! Form::text('Mobile', null, ['id'=>'mobile', 'class'=>'w3-input w3-border w3-margin-bottom']) !!} {!! Form::submit('Create', ['class'=>'w3-button w3-block w3-green w3-section w3-padding']) !!}
            </div>
            {!! Form::close() !!}

            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">

            </div>

        </div>
    </div>

    <!--................................................MODAL.................................................-->

    <div id="contactedit" class="w3-modal w3-animate-opacity">
        <div class="w3-modal-content w3-card-4 w3-animate-opacity" style="max-width:600px">

            <div class="w3-center">
                <br>
                <span onclick="document.getElementById('contactedit').style.display='none'; $('#contactediterror').empty();" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
                <div id="contactEditModalTitle"></div>
                <div class="w3-container w3-section w3-cell w3-margin-bottom" id="contactediterror"></div>

            </div>

            <div class="w3-section">
                <form id="contacteditform" class="w3-container">
                </form>
            </div>
            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">

            </div>

        </div>
    </div>

    <!--................................................MODAL.................................................-->

    <div id="supplier" class="w3-modal w3-animate-opacity">
        <div class="w3-modal-content w3-card-4 w3-animate-opacity w3-display-topmiddle" style="max-width:1200px">

            <div class="w3-center">
                <br>
                <span onclick="closeModal('supplier','upload_form','editSupplier_img','error','padrao')" class="w3-button w3-xlarge w3-red w3-hover-red w3-display-topright" title="Close Modal">&times;</span>

            </div>

            <h5 class="w3-center"><b>New Supplier</b></h5>

            {!! Form::open(['files' => true, 'class'=>'w3-container', 'id'=>'upload_form', 'enctype' => 'multipart/form-data' ]) !!}

            <div class="w3-section">

                {{Form::label('Imagem', 'Image',['class' => 'control-label'])}}

                <div class="w3-cell-row w3-margin-bottom">
                    <div class="w3-container w3-section w3-cell w3-margin-bottom">
                        @if(config('app.env') != 'local')
                            <img class="w3-margin-bottom" id="editSupplier_img" src="<?php echo asset("storage/padrao.png ")?>">
                        @else
                            <img  class="w3-margin-bottom" id="editSupplier_img" src="https://atsportugal.com/public/storage/padrao.png">
                        @endif


                    </div>
                    <div class="w3-container w3-section w3-cell w3-margin-bottom" id="error"></div>
                </div>

                <div class="w3-cell-row w3-margin-top">

                    <div class="w3-container w3-cell w3-margin-top">
                        <!-- Nome Form Input -->
                        <div class="form-group">

                            {{Form::file('path_image',['id'=>'path_image','onchange'=>"readURL(this,'#editSupplier_img')"])}}
                        </div>
                        <div class="form-group">
                            {!! Form::label('name', 'Name / Group:') !!} {!! Form::text('name', null, ['id'=>'namesup','class'=>'w3-input w3-border', 'style'=>'padding: 3px 5px;']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('social_denomination', 'Social Denomination:') !!} {!! Form::text('social_denomination', null, ['id'=>'social_denomination','class'=>'w3-input w3-border', 'style'=>'padding: 3px 5px;']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('fiscal_number', 'Fiscal Number:') !!} {!! Form::text('fiscal_number', null, ['id'=>'fiscal_number','class'=>'w3-input w3-border', 'style'=>'padding: 3px 5px;']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('web', 'Web:') !!} {!! Form::text('web', null, ['id'=>'web','class'=>'w3-input w3-border', 'style'=>'padding: 3px 5px;']) !!}
                        </div>

                    </div>

                    <div class="w3-container w3-cell w3-margin-top">
                        <div class="form-group ">
                            {!! Form::label('remarks', 'Remarks:') !!} {!! Form::textarea('remarks', null, ['id'=>'remarks','class'=>'w3-input w3-border', 'style'=>' height: 300px; resize: none;']) !!}
                        </div>

                    </div>

                </div>
                <div class="w3-cell-row">
                    <div class="w3-container w3-cell">
                        {!! Form::submit('Create', ['class'=>'w3-button w3-block w3-green w3-section w3-padding']) !!}
                    </div>
                    <div class="w3-container w3-cell">
                        {!! Form::button('Cancel', ['class'=>'w3-button w3-block w3-red w3-section w3-padding', 'onclick'=>"closeModal('supplier','upload_form','editSupplier_img','error','padrao')"]) !!}
                    </div>
                </div>
            </div>
            {!! Form::close() !!}

        </div>
    </div>

    <!--................................................MODAL.................................................-->

    <div id="createlocal" class="w3-modal w3-animate-opacity">
        <div class="w3-modal-content w3-card-4 w3-animate-opacity" style="max-width:600px">

            <div class="w3-center">
                <br>
                <span onclick="document.getElementById('createlocal').style.display='none'; $('#localcreateerror').empty();" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>

            </div>
            <h5 class="w3-center"><b>New Local</b></h5>
            <div class="w3-container w3-section w3-cell w3-margin-bottom" id="localcreateerror"></div>

            {!! Form::open([ 'class'=>'w3-container']) !!}
            <div class="w3-section">

                {!! Form::label('place', 'Place:') !!} {!! Form::text('Place', null, ['id'=>'location', 'class'=>'w3-input w3-border w3-margin-bottom']) !!} {!! Form::label('address', 'Address:') !!} {!! Form::text('Address', null, ['id'=>'address', 'class'=>'w3-input w3-border w3-margin-bottom']) !!} {!! Form::label('zip-code', 'Zip-Code:') !!} {!! Form::text('zip-code', null, ['id'=>'zip', 'class'=>'w3-input w3-border w3-margin-bottom']) !!} {!! Form::label('city', 'City:') !!} {!! Form::text('city', null, ['id'=>'city', 'class'=>'w3-input w3-border w3-margin-bottom']) !!} {!! Form::label('country', 'country:') !!} {!! Form::text('country', null, ['id'=>'country', 'class'=>'w3-input w3-border w3-margin-bottom']) !!} {!! Form::submit('Create', ['class'=>'w3-button w3-block w3-green w3-section w3-padding']) !!}
            </div>
            {!! Form::close() !!}

            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">

            </div>

        </div>
    </div>

    <!--................................................MODAL.................................................-->

    <div id="localtedit" class="w3-modal w3-animate-opacity">
        <div class="w3-modal-content w3-card-4 w3-animate-opacity" style="max-width:600px">

            <div class="w3-center">
                <br>
                <span onclick="document.getElementById('localtedit').style.display='none'; $('#localediterror').empty();" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
                <h5 class="w3-center"><b>Edit Local</b></h5>
                <div class="w3-container w3-section w3-cell w3-margin-bottom" id="localediterror"></div>
            </div>

            <div class="w3-section">
                {!! Form::open([ 'class'=>'w3-container']) !!}
                <div class="w3-section">

                    {!! Form::label('place', 'Place:') !!} {!! Form::text('Place', null, ['id'=>'editlocation', 'class'=>'w3-input w3-border w3-margin-bottom']) !!} {!! Form::label('address', 'Address:') !!} {!! Form::text('Address', null, ['id'=>'editaddress', 'class'=>'w3-input w3-border w3-margin-bottom']) !!} {!! Form::label('zip-code', 'Zip-Code:') !!} {!! Form::text('zip-code', null, ['id'=>'editzip', 'class'=>'w3-input w3-border w3-margin-bottom']) !!} {!! Form::label('city', 'City:') !!} {!! Form::text('city', null, ['id'=>'editcity', 'class'=>'w3-input w3-border w3-margin-bottom']) !!} {!! Form::label('country', 'country:') !!} {!! Form::text('country', null, ['id'=>'editcountry', 'class'=>'w3-input w3-border w3-margin-bottom']) !!} {!! Form::submit('Save', ['class'=>'w3-button w3-block w3-blue w3-section w3-padding']) !!}
                </div>
                {!! Form::close() !!}
            </div>
            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">

            </div>

        </div>
    </div>

    <!--.......................................................................................................-->

</div>
<!--.......................................................................................................-->

@endsection

<!--.......................................................................................................-->


@push('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>
@endpush
