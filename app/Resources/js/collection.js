$.fn.collection = function(options) {

    console.log($(this));
    console.log($(options.add));
    var collection =  $(this);
    var addBtn = $(options.add)
    var newBtn = $('<div class="collection-add"></div>').append(addBtn);

    collection.append(newBtn);
    collection.find(options.containerSelector).each(function () {
        addCollectionFormDeleteLink($(this), options);
    });
    newBtn.on('click', function(e) {
        e.preventDefault();
        addCollectionForm(collection, newBtn, options);
    });

    function addCollectionForm(collectionHolder, newBtn, options) {
        var prototype = collectionHolder.attr('data-prototype');

        // Remplace '__name__' dans le HTML du prototype par un nombre basé sur
        // la longueur de la collection courante
        var newForm = prototype.replace(/__name__/g, collectionHolder.children().length);

        // Affiche le formulaire dans la page dans un li, avant le lien "ajouter un tag"
        var $newFormLi = $(options.container).append(newForm);
        newBtn.before($newFormLi);
        addCollectionFormDeleteLink($newFormLi, options);
        initSelect2();
    }

    function addCollectionFormDeleteLink($tagFormLi, options) {
        var $deleteLink = $(options.delete);
        $tagFormLi.find('.collection-delete').append($deleteLink);

        $deleteLink.on('click', function (e) {
            // empêche le lien de créer un « # » dans l'URL
            e.preventDefault();
            // supprime l'élément li pour le formulaire de tag
            $tagFormLi.remove();
        });
    }
};