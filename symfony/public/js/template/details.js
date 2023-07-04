function details(data) {
    console.log(data);
    document.querySelector('#titleTemplate').innerHTML = data.name;
    document.querySelector('.primaryColor').style.backgroundColor = data.data.primaryColor;
    document.querySelector('.secondaryColor').style.backgroundColor = data.data.secondaryColor;
    document.querySelector('.witheColor').style.backgroundColor = data.data.whiteColor;
    document.querySelector('.blackColor').style.backgroundColor = data.data.blackColor;

    if (data.data.reverseRow) {
        document.querySelector('.reverseRow').innerHTML = '<p>Inversion des colonnes</p><i class="gg-check-o"></i>';
    }else{
        document.querySelector('.reverseRow').innerHTML = '<p>Inversion des colonnes</p><i class="gg-close-o"></i>';
    }

    if (data.data.stickyHeader) {
        document.querySelector('.stickyHeader').innerHTML = '<p>Navigation collé</p><i class="gg-check-o"></i>';
    }else{
        document.querySelector('.stickyHeader').innerHTML = '<p>Navigation collé</p><i class="gg-close-o"></i>';
    }

    if (data.data.specialButtonForTicket) {
        document.querySelector('.specialButton').innerHTML = '<p>Bouton spécial achat</p><i class="gg-check-o"></i>';
    }else{
        document.querySelector('.specialButton').innerHTML = '<p>Bouton spécial achat</p><i class="gg-close-o"></i>';
    }

    if (data.data.contactMapFirst) {
        document.querySelector('.mapFirst').innerHTML = '<p>Contact carte</p><i class="gg-check-o"></i>';
    }else{
        document.querySelector('.mapFirst').innerHTML = '<p>Contact carte</p><i class="gg-close-o"></i>';
    }

    if (data.data.changeCheckBoxSelect) {
        document.querySelector('.selecttoCheckBox').innerHTML = '<p>Liste déroulante</p><i class="gg-check-o"></i>';
    }else{
        document.querySelector('.selecttoCheckBox').innerHTML = '<p>Liste déroulante</p><i class="gg-close-o"></i>';
    }




}

export {details};