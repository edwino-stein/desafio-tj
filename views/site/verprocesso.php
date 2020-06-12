<?php
    $this->title = 'Desafio TJRR - Listagem de processos';
?>

<div id="principal" class="container py-4" style="display: none;">
    <h3>Processos - <span id="processo-numero"></span></h3><hr>

    <h4 class="mb-3">I - DO ENDEREÇAMENTO</h4>
    <p class="mb-5">
        Excelentissimo senhor juiz de direito <b id="juiz-nome">{NOME JUIZ}</b>
        da <b id="juiz-vara">{VARA}</b>.
    </p>

    <h4 class="mb-3">II - DAS PARTES</h4>
    <ol style="list-style-type: lower-alpha;" class="mb-5">
        <li>
            <h6>Autor</h6>
            <div id="autor"></div>
        </li>
        <li>
            <h6>Réu</h6>
            <div id="reu"></div>
        </li>
    </ol>

    <h4 class="mb-3">III - DOS FATOS E DOS FUNDAMENTOS JURÍDICOS DE DIREITO</h4>
    <p class="mb-5" id="fatos">
        {FATOS}
    </p>

    <h4 class="mb-3">IV - DOS PEDIDOS</h4>
    <p class="mb-5" id="pedidos">
        {PEDIDOS}
    </p>

    <h4 class="mb-3">V - O VALOR DA CAUSA</h4>
    <p class="mb-5">
        O valo cobrado pela causa foi estimado em <b id="processo-valor">{VALOR}</b>.
    </p>

    <h4 class="mb-3">VI - DO ENCERRAMENTO</h4>
    <div id="autor-adv"></div>
    <p class="mb-5">
        <b id="orgao-nome">{ORGAO}</b>,
        <span id="orgao-endereco">{ORGAO ENDERECO}</span>,
        <span id="orgao-cidade">{ORGAO CIDADE}</span>,
        <span id="orgao-estado">{ORGAO ESTADO}</span> -
        <b id="processo-data">{DATA}</b>.
    </p>

    <h4 class="mb-3">VII - ROL DE TESTEMUNHAS</h4>
    <div id="testemulhas">
        <h6>Não há testemulhas</h6>
    </div>
</div>

<div class="text-center">
    <a href="/" class="btn btn-link my-3">Voltar</a>
</div>

<script type="text/javascript">

    function renderEndereco(endereco)
    {
        let e = endereco.logradouro;

        e += ' nº' + endereco.numero;
        e += ', bairro ' + endereco.bairro;
        e += ', CEP ' + endereco.cep;

        return e;
    }

    function renderData(data)
    {
        const d = new Date(data.date);
        return d.toISOString().split('T')[0].split('-').reverse().join('/');
    }

    function renderPessoaTpl(pessoa)
    {
        if(pessoa.tipo == 'fisica'){

            const pessoaFisicaTpl = $($('template')[0].content).find('#pessoa-fisica')[0];
            const tpl = $(document.importNode(pessoaFisicaTpl, true));

            tpl.find('.nome').text(pessoa.nome);
            tpl.find('.nacionalidade').text(pessoa.nacionalidade);
            tpl.find('.estado-civil').text(pessoa.estado_civil);
            tpl.find('.profissao').text(pessoa.profissao);
            tpl.find('.endereco').text(renderEndereco(pessoa.endereco));
            tpl.find('.rg').text(pessoa.rg);
            tpl.find('.cpf').text(pessoa.cp);
            tpl.find('.telefone').text(pessoa.telefone);

            return tpl.removeAttr('id');
        }

        else {
            const pessoaJuridicaTpl = $($('template')[0].content).find('#pessoa-juridica')[0];
            const tpl = $(document.importNode(pessoaJuridicaTpl, true));

            tpl.find('.nome').text(pessoa.nome);
            tpl.find('.nome-fantasia').text(pessoa.fantasia);
            tpl.find('.endereco').text(renderEndereco(pessoa.endereco));
            tpl.find('.inscricao').text(pessoa.inscrissao);
            tpl.find('.cnpj').text(pessoa.cp);
            tpl.find('.telefone').text(pessoa.telefone);

            return tpl.removeAttr('id');
        }
    }

    function renderAdvogadoTpl(adv){

        const advogadoTpl = $($('template')[0].content).find('#advogado')[0];
        const tpl = $(document.importNode(advogadoTpl, true));

        tpl.find('.nome').text(adv.pessoa.nome);
        tpl.find('.oab').text(adv.oab);
        tpl.find('.endereco').text(renderEndereco(adv.pessoa.endereco));
        tpl.find('.telefone').text(adv.pessoa.telefone);

        return tpl.removeAttr('id');
    }

    $(document).ready(function(){
        const urlParams = new URLSearchParams(window.location.search);
        jQuery.ajax({
            url: '/processo/info?id=' + urlParams.get('id'),
            dataType: "json",
            method: 'GET',
            success: function(data, request){

                $('#processo-numero').text(data.numero);
                $('#juiz-nome').text(data.juiz.pessoa.nome);
                $('#juiz-vara').text(data.juiz.vara.nome);

                $('#autor').html(renderPessoaTpl(data.partes.autor));
                $('#reu').html(renderPessoaTpl(data.partes.reu));

                $('#fatos').text(data.fatos);
                $('#pedidos').text(data.pedidos);
                $('#processo-valor').text(
                    new Intl.NumberFormat(
                        'pt-BR',
                        { style: 'currency', currency: 'BRL' }
                    ).format(data.valor)
                );

                $('#processo-data').text(renderData(data.distribuicao));
                $('#orgao-nome').text(data.orgao.nome);
                $('#orgao-endereco').text(renderEndereco(data.orgao.endereco));
                $('#orgao-cidade').text(data.orgao.endereco.cidade);
                $('#orgao-estado').text(data.orgao.endereco.estado);

                $('#autor-adv').html(renderAdvogadoTpl(data.partes.autor_adv));

                $('#principal').show();
            },
            error: function(request){
                alert(request.responseText);
            },
        });

        jQuery.ajax({
            url: '/processo/testemunhas?id=' + urlParams.get('id'),
            dataType: "json",
            method: 'GET',
            success: function(data, request){

                if(data.length <= 0) return;

                const listTpl = $($.parseHTML("<ol></ol>")[0]);

                for(let i in data){
                    const itemTpl = $($.parseHTML("<li></li>")[0]);
                    itemTpl.html(renderPessoaTpl(data[i].pessoa));
                    listTpl.append(itemTpl);
                }

                $('#testemulhas').html(listTpl);
            },
            error: function(request){},
        });
    });
</script>

<template>

    <p id="pessoa-fisica">
        <b class="nome">{NOME}</b>,
        <span class="nacionalidade">{NACIONALIDADE}</span>,
        <span class="estado-civil">{ESTADO_CIVIL}</span>,
        <span class="profissao" >{PROFISSAO}</span>,
        residente em <span class="endereco">{ENDERECO}</span>,
        RG nº <span class="rg">{RG}</span>,
        CPF nº <span class="cpf">{CPF}</span>,
        telefone nº <span class="telefone">{TELEFONE}</span>.
    </p>

    <p id="pessoa-juridica">
        <b class="nome">{NOME}</b>,
        nome fantasia <span class="nome-fantasia">{NOME FANTASIA}</span>,
        localizada em <span class="endereco">{ENDERECO}</span>,
        inscrição estadual nº <span class="inscricao">{INSCRICAO ESTADUAL}</span>,
        CNPJ nº <span class="cnpj">{CNPJ}</span>,
        telefone nº <span class="telefone">{TELEFONE}</span>.
    </p>

    <p id="advogado">
        <b class="nome">{ADV NOME}</b>, OAB nº <span class="oab">{ADV OAB}</span>,
        residente em <span class="endereco">{ADV ENDERECO}</span>,
        telefone nº <span class="telefone">{ADV TELEFONE}</span>.
    </p>

</tamplate>
