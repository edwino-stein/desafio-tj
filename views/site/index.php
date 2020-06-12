<?php
    $this->title = 'Desafio TJRR - Listagem de processos';
?>

<div class="container py-4">
    <h3>Processos</h3><hr>
    <table class="table" id="tabela">
        <thead>
            <tr>
                <th scope="col">Número</th>
                <th scope="col">Assunto</th>
                <th scope="col">Data Dist.</th>
                <th scope="col">Juiz</th>
                <th scope="col" class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        jQuery.ajax({
            url: '/processo',
            dataType: "json",
            method: 'GET',
            success: function(data, request){
                const linhaTpl = $('#linha')[0].content.querySelectorAll('tr')[0];
                const table = $('#tabela tbody');
                for(let i in data){
                    const linha = $(document.importNode(linhaTpl, true));
                    const dist = new Date(data[i].distribuicao.date).toISOString().split('T')[0];

                    linha.find('.numero').html(data[i].numero);
                    linha.find('.assunto').html(data[i].assunto);
                    linha.find('.distribuicao').html(dist.split('-').reverse().join('/'));
                    linha.find('.juiz').html(data[i].juiz.pessoa.nome);

                    linha.find('.visualizar').attr('href', '/site/verprocesso?id='+data[i].id);

                    table.append(linha);
                }
            },
            error: function(request){
                console.error(request);
            },
            complete: function(){}
        });
    });
</script>

<template id="linha">
    <tr>
        <th scope="row" class="numero">numero</th>
        <td class="assunto">assunto</td>
        <td class="distribuicao">distribuição</td>
        <td class="juiz">juiz</td>
        <td class="acoes text-center">
            <a class="visualizar" href="#"><i class="far fa-eye"></i></a>
        </td>
    </tr>
</tamplate>
