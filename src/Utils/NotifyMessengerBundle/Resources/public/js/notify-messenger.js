$(function () {
    Messenger.options = {
        extraClasses: 'messenger-fixed',
        theme: 'block'
    };
    $('.messenger-success').each(function () {
        Messenger().post({
            message: this.dataset.message,
            type: 'success'
        });
    });
    $('.messenger-info').each(function () {
        Messenger().post({
            message: this.dataset.message,
            type: 'info'
        });
    });
    $('.messenger-error').each(function () {
        Messenger().post({
            message: this.dataset.message,
            type: 'error'
        });
    });
});