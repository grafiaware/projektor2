<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

$p = "Pangram pro úplnou sadu znaků české abecedy:

    Nechť již hříšné saxofony ďáblů rozezvučí síň úděsnými tóny waltzu, tanga a quickstepu.

Variantou je pangram, ve kterém se bere ohled pouze na to, aby byla zastoupena všechna písmena s diakritikou. V češtině se nejčastěji k takovému účelu (např. pro testování podpory znaků národních abeced u počítačů) používá věta:

    Příliš žluťoučký kůň úpěl ďábelské ódy.

nebo její nepatrně kratší verze:

    Příliš žluťoučký kůň úpěl ďábelské ó.

K podobným účelům mohou sloužit též například věty:

    Zvlášť zákeřný učeň s ďolíčky běží podél zóny úlů.
    Vyciď křišťálový nůž, ó učiň úděsné líbivým!
    Loď čeří kýlem tůň obzvlášť v Grónské úžině.
    Ó, náhlý déšť již zvířil prach a čilá laň teď běží s houfcem gazel k úkrytům. (chybí znaky Q, W, X)
    Ó, náhlý déšť již zvířil prach a čilá laň teď běží s houfcem gazel Ualdewara k exkluzívním úkrytům. (chybí znak Q)

Z nich ovšem pouze předposlední[zdroj?] sdílí s výše uvedenou větou příliš žluťoučký kůň úpěl ďábelské ódy vlastnost, že každé písmeno s diakritikou se vyskytuje právě jednou. Nahradíme-li například příliš za příšerně, písmeno Ě se vyskytne dvakrát (již je obsaženo v úpěl), což může být pro některé účely nevhodné. ";

$postValue = filter_var($p, FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW); 
echo $postValue;