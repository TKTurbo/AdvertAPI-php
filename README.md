#Functionaliteit van de node app, maar in php.

Ik heb de content en de link opgesplitst in twee GET parameters, omdat alle links redirects zijn.

##Hoe gebruik je het?
Stel, we hebben een entry 1 met het type image en een entry 2 met het type text.

De image roep je zo aan:

    <a id="'entry' + ((ID))" href="((URL))?linkID=((ID))">
        <img src="((URL))?ID=((ID)">
    </a>

Een normale text zo:

    <a id="'entry' + ((ID))" href="((URL))?linkID=((ID))">((URL))
    </a>
    
    // Hier een GET-request. Voorbeeld in axios.
    
    axios.get(((URL)) + '?ID=' + ((ID)))
        .then(function (response) {
        document.getElementById('entry' + ((ID))).innerHTML = response.data
    })

Hierbij is **((URL))** natuurlijk de URL van de app, en **((ID))** het ID van de entry. 

Voor text is de GET-request wel nodig, omdat je de daadwerkelijk de body van een php echo moet hebben. Voor link redirects is dat niet nodig.
