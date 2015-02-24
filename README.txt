[IT]

PHP FAST PAGINATION

Questa classe permette di ottenere in modo performante (a mio avviso anche elegante), 
i dati necessari alla costruzione di una webpage contenente una paginazione.

Per funzionare ha bisogno di:

1-una istanza della classe PDO
2-l'indice attuale della paginazione (La classe contiene anche la costante DEFAULT_START_PAGE valorizzata di default a 1) 
3-la quantità di dati da visualizzare per ogni pagina (La classe contiene anche la costante DEFAULT_QUANTITY valorizzata di default a 5)
4-il nome della tabella in cui risiedono i dati da paginare
5-(OPZIONALE) Eventuale condizione di WHERE
6-(OPZIONALE) array per il binding dell'eventuale condizione WHERE

Funziona per i seguenti RDBMS:

mysql;
postegreSQL;
sqLite;
Cubrid;
Oracle; 

Nel caso in cui il db utilizzato non rientri in quelli elencati, è possibile aggiungere il codice per il tuo db 
modificando la function PFPaginator->createQuery(), aggiungendo nello switch il tuo db e la tua logica di paginazione.
L'operazione è abbastanza semplice e intuitiva, ti basterà osservare cosa è stato fatto per tutti gli altri 
e replicarlo per il tuo scopo. 

Dati in Output
	PFPaginator->getData()
		Restituisce un array contenente i dati (colonne della tabella) per la pagina da visualizzare.

	PFPaginator->getMenu()
		Restituisce un array di dati utili per la costruzione di un menu personalizzato.
		l'array è composto come segue:
		
		$this->menu['ALL_DATA_COUNT'] // Il count totale dei dati oggetto della paginazione 
        $this->menu['MAX_PAGINATION_INDEXES'] // L'indice massimo calcolato per la paginazione
        $this->menu['ACTUAL_INDEX'] // L'indice attuale utilizzato
        $this->menu['NEXT_INDEX'] 	// Il prossimo indice
        $this->menu['PREVIOUS_INDEX'] //L'indice precedente
        
[EN]
PHP FAST PAGINATION 
This class allows you to get so powerful (in my opinion also elegant), 
the data needed to build a webpage containing a paging.       

To work needs:

1-an instance of the PDO class 
2-the current pagination index (The class also contains the constant DEFAULT_START_PAGE, enhanced by default to 1) 
3-the amount of data you want to display per page (The class also contains the constant DEFAULT_QUANTITY, enhanced by default to 5) 
4-the name of the table where the data are stored 
5-(optional) Any WHERE condition 
6-(optional) array to bind any WHERE condition
       
Works for the following RDBMS: 
mysql;
postegreSQL;
sqLite;
Cubrid;
Oracle; 

In case the db used does not fall into those listed, you can add the code to your db 
by changing the function PFPaginator->createQuery (), adding in the switch your db and your paging logic. 
The operation is quite simple and intuitive, just look at what has been done to everyone else and replicate it for your purpose.


Output data 

	PFPaginator > GetData() //Returns an array containing the data (table columns) for the page to display. 
	
	PFPaginator-> getMenu () Returns an array of useful data for the construction of a custom menu.
	 the array is composed as follows:
	 
	 	$this->menu['ALL_DATA_COUNT'] // The total count of the data subject to the paging 
        $this->menu['MAX_PAGINATION_INDEXES'] // The maximum index calculated for paging
        $this->menu['ACTUAL_INDEX'] // The current index used
        $this->menu['NEXT_INDEX'] 	// The next index
        $this->menu['PREVIOUS_INDEX'] // The previous index