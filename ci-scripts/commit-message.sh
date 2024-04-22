#!/bin/bash

# Récupère la branche courante
current_branch=$(git symbolic-ref --short HEAD)

# Exclut les branches master, preproduction, et recette
if [[ $current_branch == "master" || $current_branch == "preproduction" || $current_branch == "recette" ]]; then
    exit 0
fi

# Extrait le numéro du ticket à partir du nom de la branche
ticket_number=$(echo "$current_branch" | awk -F'/' '/^[^master|^preproduction|^recette]/{print $2}')
# Vérifie si le message du commit commence par le numéro du ticket
commit_message=$(cat "$1")

if [[ $commit_message == "$ticket_number"* ]]; then
    echo "Commit accepté."
    exit 0
else
    echo "Erreur : Le message du commit ne commence pas par le numéro du ticket $ticket_number."
    exit 1
fi
