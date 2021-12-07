const addFormToCollection = (e) => {
    console.log("asdf'")
    const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);

    const item = document.createElement('li');

    item.innerHTML = collectionHolder
        .dataset
        .prototype
        .replace(
            /__name__/g,
            collectionHolder.dataset.index
        );

    collectionHolder.appendChild(item);

    collectionHolder.dataset.index++;
};



// var $collectionHolder;
// var $addNewLine = $('<a href="#" class="btn btn-info">Add new line</a>');
//
// $(document).ready(function () {
//     $collectionHolder = $('#exp_list');
//     $collectionHolder.append($addNewLine);
//     $collectionHolder.data('index', $collectionHolder.find('.panel').length)
//     $collectionHolder.find('.panel').each(function () {
//         addRemoveButton($(this));
//     });
//
//     $addNewLine.click(function (e) {
//         e.preventDefault();
//         addNewForm();
//     })
// });
// /*
//  * creates a new form and appends it to the collectionHolder
//  */
// function addNewForm() {
//     var prototype = $collectionHolder.data('prototype');
//     var index = $collectionHolder.data('index');
//     var newForm = prototype;
//     newForm = newForm.replace(/__name__/g, index);
//     $collectionHolder.data('index', index+1);
//     var $panel = $('<div class="panel-heading"></div>');
//     var $panelBody = $('<div class="panel-body"></div>').append(newForm);
//
//     $panel.append($panelBody);
//     $addNewLine.before($panel);
// }