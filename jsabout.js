function bookClass() {
    let regularClass = 5;
    let aerialAdults = 10;
    let kidsYoga = 3;

    var itemTable = document.getElementsByTagName("table")[0];
    var name = document.getElementById("name");
    var Class = document.getElementById("classType");
    var date = document.getElementById("date");

    if(name.value == "" || Class.value == "" || date.value == ""){
        window.alert("Please make sure to fill all the fields")
    }else{
        var itemRow = document.createElement("tr");
        var nameCell = document.createElement("td");
        var classCell = document.createElement("td");
        var dateCell = document.createElement("td");
        var priceCell = document.createElement("td");
        
        nameCell.innerHTML = name.value;
        classCell.innerHTML = Class.value;
        dateCell.innerHTML = date.value;
        if (Class.value == 'Aerial Kids' || Class.value == 'Arm Balance' || Class.value == 'Core & Glutes' || Class.value == 'Yin yoga' || Class.value == 'Gentle Flow' || Class.value == 'Meditation') {
            priceCell.innerHTML = '$' + regularClass.valueOf(regularClass);
        } else if (Class.value == 'Aerial Adults') {
            priceCell.innerHTML = '$' + aerialAdults.valueOf(aerialAdults);
        } else if (Class.value == 'Kids yoga') {
            priceCell.innerHTML = '$' + kidsYoga.valueOf(kidsYoga);
        }
        
        itemRow.appendChild(nameCell);
        itemRow.appendChild(classCell);
        itemRow.appendChild(dateCell);
        itemRow.appendChild(priceCell);
    
        itemTable.appendChild(itemRow);
        name.value = "";
        Class.value = "";
        date.value = "";
    }
}