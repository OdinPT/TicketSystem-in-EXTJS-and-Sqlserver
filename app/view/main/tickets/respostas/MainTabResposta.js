Ext.define('TrackIT.view.main.tickets.respostas.MainTabResposta', {
    extend: 'Ext.tab.Panel',
    xtype: 'maintabresposta',
    controller: 'respostacont',
    requires: [
        'TrackIT.store.respostas.RespostaSeleccionada',
        'TrackIT.view.main.tickets.respostas.RespostaController',
        'TrackIT.view.main.tickets.respostas.MostraResposta'
    ],



    width: 1180,
    height: 410,

    store: {
        type: 'respostaseleccionada'
    },

    defaults: {
       // bodyPadding: 10,
        scrollable: true,
        closable: true
    },

    items: [{
        title: 'Conteúdo da Resposta ',
        items: {
                  xtype: 'fieldresposta'
}
    }
]
});
