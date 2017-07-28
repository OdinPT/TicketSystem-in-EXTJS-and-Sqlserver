
Ext.define('TrackIT.view.main.tickets.HisEst.GridMostrafuncionarios', {
    extend: 'Ext.grid.Panel',
    id: 'gridhisest2',
    xtype: 'mainlisthistoricoest',
    requires: [
        'TrackIT.store.HistoricoEstados.HistoricoEstado',
        'Ext.toolbar.Paging'],

    config: {
        autoLoad: true,
        scroll:true,
        style:{overflow: 'auto',overflowX: 'hidden'},
        width: 1090
    },
    layout: {
        align: 'fit',
        type: 'form'
    },
    store: {
        type: 'HistoricoEstados'
    },

    columns: [
        { text: 'ID',  dataIndex: 'idHistoricoEstados', flex: 0.1},
        { text: 'Hora de atribuição ',  dataIndex: 'HoraAtribuicaoEstado', flex: 0.5},
        { text: 'Id Ticket', dataIndex: 'IdTicketEstado', flex: 0.2},
        { text: 'Estado', dataIndex: 'Descricao_Estado', flex: 0.3},
        { text: 'Nome de utilizador', dataIndex: 'username', flex: 0.5},
        { text: 'Estado de Resoluçao', dataIndex: 'DesTipoRes', flex: 0.5}
    ],

    onGridAfterRender: function(gridhisest){
        setInterval(function(){
            grid.store.load();
        }, 1);
    }
});