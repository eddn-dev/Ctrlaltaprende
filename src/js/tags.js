(function(){
    const tagsInput = document.querySelector('#tags_input');
    
    if(tagsInput){
        tagsDiv = document.querySelector('#tags');
        tagsHiddenInput = document.querySelector('[name="tags"]');
        
        let tags = [];

        //Get from the input hidden
        if(tagsHiddenInput.value !== ''){
            tags = tagsHiddenInput.value.split(',');
            showTags();
        }

        tagsInput.addEventListener('keypress', saveTag);
        

        function saveTag(e){
            if(e.keyCode == 44){

                if(e.target.value.trim() === '' || e.target.value < 1){ return ;}
                e.preventDefault();
                tags = [...tags, e.target.value.trim()];
                tagsInput.value = '';

                showTags();
            }
        }

        function showTags(){
            tagsDiv.textContent = '';

            tags.forEach(tag =>{
                const tip = document.createElement('LI');
                tip.classList.add('skill__tag');
                tip.textContent = tag;
                tip.ondblclick = deleteTag;
                tagsDiv.appendChild(tip);
            })

            updateHiddenInput();
        }

        function updateHiddenInput(){
            tagsHiddenInput.value = tags.toString();
        }

        function deleteTag(e){
            e.target.remove();
            tags = tags.filter(tag => tag !== e.target.textContent);
            updateHiddenInput();
        }
    }
})() //IIFE