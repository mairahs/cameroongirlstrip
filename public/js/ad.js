$('#add_image').click(function(){
    // récupération du numéro des futures entrées qui seront créer
    const index = +$('#widgets-counter').val();

    // récupération du prototype des entrées (html)
    const template = $('#annonce_images').data('prototype').replace(/_name_/g, index);

    // injection de ce code au sein de la div
    $('#annonce_images').append(template);
    $('#widgets-counter').val(index + 1);

    //gestion du bouton de suppression
    handleDeleteButtons();
});
function handleDeleteButtons()
{
    $('button[data-action="delete"]').click(function(){
        const target = this.dataset.target;
        $(target).remove();
    });
}
handleDeleteButtons();