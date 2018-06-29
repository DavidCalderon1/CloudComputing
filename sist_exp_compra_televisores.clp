;;
;;  Sistema experto para comprar un televisor
;;  Unipanamericana - Fundacion Universitaria Panamericana
;;  Sistemas Expertos
;;  Intersemestral - Noche
;;

(deftemplate televisor "plantilla para definir las caracteristicas de los televisores"
	 (slot modelo)
	 (multislot marca)
	 (multislot pulgadas)
	 (slot tecnologia)
	 (multislot resolucion)
	 (slot smarttv)
	 (slot puertousb)
	 (slot entradahdmi)
	 (multislot entradavga)
	 (slot bluethoot)
	 (slot precio (type NUMBER) (default ?NONE))
)

(deffacts televisor-database "Agregamos nuestra base de datos de televisores a los hechos."

    ;;; LG L1
    (televisor 
        (modelo l1)
        (marca lg)
        (pulgadas 28)
        (tecnologia led)
        (resolucion fhd)
        (precio 600000)
    )
    ;;; KALLEY K1
    (televisor 
        (modelo k1)
        (marca kalley)
        (pulgadas 32)
        (tecnologia lcd)
        (resolucion hd)
        (bluethoot si)
        (precio 650000)
    )
    ;;; KALLEY K2
    (televisor 
        (modelo k2)
        (marca kalley)
        (pulgadas 40)
        (tecnologia led)
        (resolucion fhd)
        (entradahdmi si)
        (precio 800000)
    )
    ;;; SAMSUNG S1
    (televisor 
        (modelo s1)
        (marca samsung)
        (pulgadas 32)
        (tecnologia led)
        (resolucion fhd)
        (puertousb si)
        (entradahdmi si)
        (precio 850000)
    )
    ;;; LG L3
    (televisor 
        (modelo l3)
        (marca lg)
        (pulgadas 43)
        (tecnologia led)
        (resolucion fhd)
        (smarttv si)
        (puertousb si)
        (entradahdmi si)
        (entradavga si)
        (precio 1130000)
    )
    ;;; LG L2
    (televisor 
        (modelo l2)
        (marca lg)
        (pulgadas 43)
        (tecnologia led)
        (resolucion fhd)
        (smarttv si)
        (puertousb si)
        (entradahdmi si)
        (bluethoot si)
        (precio 1200000)
    )
    ;;; SONY SO1
    (televisor 
        (modelo so1)
        (marca sony)
        (pulgadas 49)
        (tecnologia led)
        (resolucion fhd)
        (smarttv si)
        (puertousb si)
        (entradahdmi si)
        (entradavga si)
        (precio 1500000)
    )
    ;;; SAMSUNG S2 
    (televisor 
        (modelo s2)
        (marca samsung)
        (pulgadas 43)
        (tecnologia lcd)
        (resolucion uhd)
        (smarttv si)
        (puertousb si)
        (entradahdmi si)
        (entradavga si)
        (precio 1500000)
    )
    ;;; SONY SO2
    (televisor 
        (modelo so2)
        (marca sony)
        (pulgadas 43)
        (tecnologia lcd)
        (resolucion uhd)
        (smarttv si)
        (puertousb si)
        (entradahdmi si)
        (bluethoot si)
        (precio 2100000)
    )
    ;;; SAMSUNG S3 
    (televisor 
        (modelo s3)
        (marca samsung)
        (pulgadas 55)
        (tecnologia lcd)
        (resolucion uhd)
        (smarttv si)
        (puertousb si)
        (entradahdmi si)
        (entradavga si)
        (bluethoot si)
        (precio 3800000)
    )
    ;;; SONY SO3
    (televisor 
        (modelo so3)
        (marca sony)
        (pulgadas 49)
        (tecnologia lcd)
        (resolucion uhd)
        (smarttv si)
        (puertousb si)
        (entradahdmi si)
        (bluethoot si)
        (precio 9000000)
    )

)



;;; Un contador global que contiene la cantidad de televisores disponibles.

(defglobal ?*counter* = 11)

;;; La variable anterior se está modificando con esta función cada vez que excluimos un televisor de
;;; las posibles soluciones. (minusOne) disminuye el contador global en uno.

(deffunction minusOne ()
    (bind ?*counter* (- ?*counter* 1))
)

;;; Esta función se usa para cada pregunta hecha al usuario.
;;; La pregunta que se imprime al usuario se divide en tres argumentos (?qBEG ?qMID ?qEND) para mayor flexibilidad, ya que es posible que necesitemos incluir un texto imprimible en el medio.
;;; El argumento $?allowed-values es una lista que contiene los valores permitidos que acepta el programa.
;;; Si el usuario ingresa un valor no aceptable, el programa vuelve a hacer la pregunta hasta que la respuesta sea válida.

(deffunction ask-question (?qBEG ?qMID ?qEND $?allowed-values)
    (printout t ?qBEG ?qMID ?qEND)
    (bind ?answer (read))
    (if (lexemep ?answer)
        then (bind ?answer (lowcase ?answer))
    )
    (while (not (member ?answer ?allowed-values)) do
        (printout t ?qBEG ?qMID ?qEND)
        (bind ?answer (read))
        (if (lexemep ?answer)
            then (bind ?answer (lowcase ?answer)))
    )
?answer)


;;; La primera pregunta principal hecha al usuario. Pedimos el presupuesto mayor a 1'500.0000, esperando una respuesta si o no.
;;; El resultado se almacena como el siguiente hecho: (elPresupuesto ?presupuesto)
(defrule mainQuestion-Presupuesto
    ?x <- (initial-fact)
    =>
    (retract ?x)
    (bind ?presupuesto (ask-question "### Su presupuesto es mayor a $1'500.000? (si/no) ### " "" "" si no))
    (assert (elPresupuesto ?presupuesto))   
)


;;; Dado que el hecho (elPresupuesto ?presupuesto) existe, esta regla se activa.
;;; Esta regla filtra los televisores por tamaño y borra aquellos que no están en el grupo dado.
;;; Además, cada vez que retraemos un televisor, restamos uno de la variable global *counter* llamando a la función (minusOne).

(defrule filterBy-Presupuesto
    (elPresupuesto ?p)
    ?telev <- (televisor (precio ?precio))
    =>
    (if (eq ?p no)
        then (if (>= ?precio 1500000) then (retract ?telev) (minusOne))
    else (if (eq ?p si)
            then (if (< ?precio 1500000) then (retract ?telev) (minusOne))
         )
    )
)

;;; La segunda pregunta principal es sobre las pulgadas del televisor. El usuario puede escribir cualquiera de las pulgadas de la lista aceptable entre paréntesis.
;;; El resultado se almacena como el siguiente hecho: (lasPulgadas ?pulgadas)

(defrule mainQuestion-Pulgadas-si
    (elPresupuesto si)
    =>
    (bind ?pulgadas (ask-question "### De cuantas pulgadas lo prefiere? (43 49 55) ### " "" "" 43 49 55))
    (assert (lasPulgadas ?pulgadas))
)
(defrule mainQuestion-Pulgadas-no
    (elPresupuesto no)
    =>
    (bind ?pulgadas (ask-question "### De cuantas pulgadas lo prefiere? (28 32 40 43) ### " "" "" 28 32 40 43))
    (assert (lasPulgadas ?pulgadas))
)

;;; Dado que el hecho (lasPulgadas ?pulgadas) existe, esta regla se activa. Es muy similar a la regla filterBy-Presupuesto.
;;; Esta regla filtra los televisores por pulgadas y elimina aquellos que no tienen estas pulgadas en la lista de pulgadas.
;;; Además, cada vez que retraemos un televisor, restamos uno de la variable global *counter* llamando a la función (minusOne).

(defrule filterBy-Pulgadas
    (lasPulgadas ?t)
    ?telev <- (televisor (pulgadas $?pulgadas))
    =>
    (if (not (member$ ?t $?pulgadas))
        then (retract ?telev) (minusOne)
    )
)

;;; Después del proceso de filtrado de precio y pulgadas, verificamos la variable global? *counter*.
;;; Si nos queda 1 televisor, este es el resultado y afirmamos (found true) para activar a continuación la regla de impresión de éxito.
;;; Si nos quedan 0 televisores, afirmamos (found false) ya que no hay televisores que pasaron el filtrado.
;;; Si tenemos más de uno, necesitamos más hechos para llegar a una conclusión, por lo que afirmamos (necesitoMasHechos ?precio ?pulgadas) Para que el programa continúe preguntando.

(defrule evaluacionPosteriorAlFiltrado
    ?precio <- (elPresupuesto ?p)
    ?pulgadas <- (lasPulgadas ?t)
    =>
    (retract ?precio ?pulgadas)
    (if (eq ?*counter* 1)
        then (assert (found true))
    else (if (eq ?*counter* 0)
            then (assert (found false))
         ) 
    else (if (> ?*counter* 1)
            then (assert (necesitoMasHechos ?p ?t))
         ) 
    )   
)

;;; Dado el hecho (necesitoMasHechos? ?p ?t) donde ?p es el precio y ?t son las pulgadas que el usuario ha preguntado, hacemos una pregunta más específica sobre el televisor
;;; que estamos buscando. Luego afirmamos un hecho en la siguiente forma: (ask X Y) donde X es un campo de la plantilla televisor e Y es lo que estamos buscando en X.

(defrule necesitoMasHechos
    ?q <-(necesitoMasHechos ?p ?t)
    =>
    (retract ?q)
    (if (and (eq ?p si) (eq ?t 43))
        then (assert (ask marca sony))
    )
    (if (and (eq ?p si) (eq ?t 49))
        then (assert (ask resolucion fhd))
    )
    (if (and (eq ?p no) (eq ?t 32))
        then (assert (ask marca samsung))
    )
    (if (and (eq ?p no) (eq ?t 43))
        then (assert (ask entradavga si))
    )
)

;;; Con base en la afirmación que se hizo sobre la regla anterior, hacemos una pregunta específica sobre la marca del televisor.
;;; De acuerdo con la tabla de análisis, solo habrá dos posibles elecciones cuando la pregunta sea sobre la marca del televisor.
;;; Escogemos esos dos hechos, nos aseguramos de que sean diferentes y hacemos la pregunta.
;;; Luego, según la respuesta del usuario, retractamos uno de ellos y hemos llegado a una solución. Luego afirmamos el hecho (found true).

(defrule askMarca
    ?q <-(ask marca ?ans)
    ?telev1 <- (televisor (marca $?content1))
    (test (member$ ?ans $?content1))
    ?telev2 <- (televisor (marca $?content2))
    (test (neq ?telev1 ?telev2))
    =>
    (retract ?q)
    (bind ?a (ask-question "### Le gustaria un televisor de la marca " ?ans "? (si/no) ### " si no))
    (if (eq ?a si)
        then (retract ?telev2) (minusOne)
        else (retract ?telev1) (minusOne)
    )
    (if (eq ?*counter* 1)
        then (assert (found true))
    )
)

;;; Esta regla sigue la misma idea que la regla anterior. Dos posibles televisores, uno se filtra y obtenemos una solución.

(defrule askResolucion
    ?q <-(ask resolucion ?ans)
    ?telev1 <- (televisor (resolucion $?content1))
    (test (member$ ?ans $?content1))
    ?telev2 <- (televisor (resolucion $?content2))
    (test (neq ?telev1 ?telev2))
    =>
    (retract ?q)
    (bind ?a (ask-question "### Quiere un televisor con una resolucion " ?ans "? (si/no) ### " si no))
    (if (eq ?a si)
        then (retract ?telev2) (minusOne)
        else (retract ?telev1) (minusOne)
    )
    (if (eq ?*counter* 1)
        then (assert (found true))
    )
)

;;; Esta regla sigue la misma idea que la regla anterior. Dos posibles televisores, uno se filtra y obtenemos una solución.

(defrule askEntradavga
    ?q <-(ask entradavga ?ans)
    ?telev1 <- (televisor (entradavga $?content1))
    (test (member$ ?ans $?content1))
    ?telev2 <- (televisor (entradavga $?content2))
    (test (neq ?telev1 ?telev2))
    =>
    (retract ?q)
    (bind ?a (ask-question "### Quiere un televisor que " ?ans " tenga entrada VGA? (si/no) ### " si no))
    (if (eq ?a si)
        then (retract ?telev2) (minusOne)
        else (retract ?telev1) (minusOne)
    )
    (if (eq ?*counter* 1)
        then (assert (found true))
    )
)



;;; Si el hecho (found true) está presente, significa que solo tenemos un hecho (televisor) en la memoria, por lo tanto, hemos llegado a la conclusión de que
;;; es que el usuario busca. Asignamos este televisor a la variable ?telev e imprimimos su marca y modelo al usuario.

(defrule matchFound
    ?f <- (found true)
    ?telev <- (televisor (marca ?m) (modelo ?mo) (precio ?pr))
    =>
    (retract ?f ?telev)
    (printout t "*********************" crlf)
    (printout t "* Televisor encontrado!" crlf)
    (printout t "* Marca: " ?m crlf)
    (printout t "* Modelo: " ?mo crlf)
    (printout t "* Precio: $" ?pr crlf)
    (printout t "*********************" crlf)
)


;;; Al igual que la regla anterior, si el hecho (found false) está presente, no tenemos hechos (televisores) en la memoria. Esto significa que no hay resultados
;;; con los criterios dados. Luego imprimimos la falla al usuario.

(defrule matchNotFound
    ?f <- (found false)
    =>
    (retract ?f)
    (printout t "*********************" crlf)
    (printout t "* Ningun televisor coincide con su descripcion!" crlf)
    (printout t "*********************" crlf)
)