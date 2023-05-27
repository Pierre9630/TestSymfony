let date = document.querySelector('#date');
let nbcutlery = document.querySelector('#nbcutelry');
let slots = document.querySelector('#slot');

let datevalue = null;
let nbcutleryvalue = null;
date.addEventListener('change', (e) =>{
    const selectedDate = new Date(e.currentTarget.value);

    const year = selectedDate.getFullYear();
    const month = String(selectedDate.getMonth() + 1).padStart(2, '0');
    const day = String(selectedDate.getDate()).padStart(2, '0');
    const hours = String(selectedDate.getHours()).padStart(2, '0');
    const minutes = String(selectedDate.getMinutes()).padStart(2, '0');
    const seconds = String(selectedDate.getSeconds()).padStart(2, '0');

    datevalue = `${year}-${month}-${day} %20 ${hours}:${minutes}:${seconds}`;
    console.log(datevalue);
    //console.log(datevalue);
});
//datevalue = datevalue.format("yyyy/mm/dd h:i:s");
console.log(datevalue);
nbcutlery.addEventListener('change', (e) =>{
    nbcutleryvalue = e.currentTarget.value;
    //console.log(datevalue);
});


//console.log();
setInterval(function () {
    // executer tous les x seconds

    //console.log(process.env.APIRES);
    if(datevalue && nbcutleryvalue){
        //const encodedDateValue = encodeURIComponent(datevalue);
        //console.log(encodedDateValue);
        fetch(`http://127.0.0.1:8000/API?nbcutlery=${nbcutleryvalue}&date=${datevalue}`, {
            method: 'GET',
            headers: {
                "Accept": "application/json",
            },
        })
            .then(response => {
                // traitement de la réponse
                return response.json();
            })
            .then(data => {
                // Effacer les éléments existants
                slots.remove();

                // Recréer les éléments à partir des données obtenues
                data.slots.forEach(slotTime => {
                    const button = document.createElement('button');
                    button.setAttribute('id', 'slot');
                    button.setAttribute('type', 'submit');
                    button.textContent = slotTime;
                    slots.appendChild(button);
                });
            })
            .catch(error => {
                // Gérer les erreurs
                console.log("Une erreur s'est produite :", error);
            });


    }

},6000)

console.log(document.querySelector('#date').value);