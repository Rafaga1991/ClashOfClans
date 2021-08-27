function onClickNewListWait(element, tag){
    if($(element)[0].checked){
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'list[]';
        input.id = tag.replace('#', 'ID-');
        input.value = tag;
        $(element.parentNode.parentNode.parentNode.parentNode.parentNode)[0].append(input);
    }else{
        element.parentNode.parentNode.parentNode.parentNode.parentNode.removeChild($(tag.replace('#', '#ID-'))[0]);
    }
}