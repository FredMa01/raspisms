<?php

/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace models;

    class DataBase extends \descartes\Model
    {

        //
        // PARTIE DES REQUETES RECEIVEDS
        //


        /**
         * Récupère les receiveds dont l'id fait partie de la liste fournie.
         *
         * @param array $receiveds_ids = Tableau des id des receiveds voulus
         *
         * @return array : Retourne un tableau avec les receiveds adaptés
         */
        public function getReceivedsIn($receiveds_ids)
        {
            $query = '
				SELECT *
				FROM received
				WHERE id ';

            //On génère la clause IN et les paramètres adaptés depuis le tableau des id
            $generted_in = $this->_generate_in_from_array($receiveds_ids);
            $query .= $generted_in['QUERY'];
            $params = $generted_in['PARAMS'];

            return $this->_run_query($query, $params);
        }


        //
        // PARTIE DES REQUETES GROUPS_CONTACTS
        //

        /**
         * Retourne tous les contacts pour un group donnée.
         *
         * @param int $id_group : L'id du group
         *
         * @return array : Tous les contacts compris dans le group
         */
        public function getContactsForGroup($id_group)
        {
            $query = '
				SELECT con.id as id, con.name as name, con.number as number
				FROM group_contact as g_c
				JOIN contact as con
				ON (g_c.id_contact = con.id)
				WHERE(g_c.id_group = :id_group)
			';

            $params = [
                'id_group' => $id_group,
            ];

            return $this->_run_query($query, $params);
        }

        //
        // PARTIE DES REQUETES SCHEDULEDS
        //

        /**
         * Récupère tout les sms programmés non en cours, et dont la date d'envoie inférieure à celle renseignée.
         *
         * @param string $date : \Date avant laquelle on veux les sms
         *
         * @return array : Tableau avec les sms programmés demandés
         */
        public function getScheduledsNotInProgressBefore($date)
        {
            $query = '
				SELECT *
				FROM scheduled
				WHERE progress = 0
				AND at <= :date
			';

            $params = [
                'date' => $date,
            ];

            return $this->_run_query($query, $params);
        }

        /**
         * Supprime tous les sms programmés dont l'id fait partie du tableau fourni.
         *
         * @param $contacts_ids : Tableau des id des sms à supprimer
         * @param mixed $scheduleds_ids
         *
         * @return int : Nombre de lignes supprimées
         */
        public function deleteScheduledsIn($scheduleds_ids)
        {
            $query = '
				DELETE FROM scheduled
				WHERE id ';

            //On génère la clause IN et les paramètres adaptés depuis le tableau des id
            $generted_in = $this->_generate_in_from_array($scheduleds_ids);
            $query .= $generted_in['QUERY'];
            $params = $generted_in['PARAMS'];

            return $this->_run_query($query, $params, self::ROWCOUNT);
        }

        //
        // PARTIE DES REQUETES SCHEDULEDS_CONTACTS
        //

        /**
         * Change le statut des scheduleds dont l'id est fourni dans $scheduleds_id.
         *
         * @param array $scheduleds_ids = Tableau des id des sms voulus
         * @param mixed $progress
         *
         * @return int : Retourne le nombre de lignes mises à jour
         */
        public function updateProgressScheduledsIn($scheduleds_ids, $progress)
        {
            $query = '
				UPDATE scheduled
				SET progress = :progress
				WHERE id ';

            //On génère la clause IN et les paramètres adaptés depuis le tableau des id
            $generted_in = $this->_generate_in_from_array($scheduleds_ids);
            $query .= $generted_in['QUERY'];
            $params = $generted_in['PARAMS'];
            $params['progress'] = (bool) $progress;

            return $this->_run_query($query, $params, self::ROWCOUNT);
        }

        //
        // PARTIE DES REQUETES SCHEDULEDS_NUMBERS
        //

        /**
         * Retourne tous les numéros pour un scheduled donné.
         *
         * @param int $id_scheduled : L'id du scheduled
         *
         * @return array : Tous les numéro compris dans le scheduled
         */
        public function getNumbersForScheduled($id_scheduled)
        {
            $query = '
				SELECT *
				FROM scheduled_number
				WHERE id_scheduled = :id_scheduled
			';

            $params = [
                'id_scheduled' => $id_scheduled,
            ];

            return $this->_run_query($query, $params);
        }

        //
        // PARTIE DES REQUETES SCHEDULEDS_GROUPS
        //

        /**
         * Retourne tous les groups pour un scheduled donnée.
         *
         * @param int $id_scheduled : L'id du schedulede
         *
         * @return array : Tous les groups compris dans le scheduled
         */
        public function getGroupsForScheduled($id_scheduled)
        {
            $query = '
				SELECT gro.id as id, gro.name as name
				FROM scheduled_group as s_g
				JOIN group as gro
				ON (s_g.id_group = gro.id)
				WHERE(s_g.id_scheduled = :id_scheduled)
			';

            $params = [
                'id_scheduled' => $id_scheduled,
            ];

            return $this->_run_query($query, $params);
        }

        //
        // PARTIE DES REQUETES USERS
        //

        /**
         * Récupère un utilisateur à partir de son email.
         *
         * @param string $email = L'email de l'utilisateur
         *
         * @return array : Retourne l'utilisateur
         */
        public function getUserFromEmail($email)
        {
            $query = '
				SELECT *
				FROM user
				WHERE email = :email';

            $params = [
                'email' => $email,
            ];

            return $this->_run_query($query, $params, self::FETCH);
        }

        //
        // PARTIE DES REQUETES TRANSFERS
        //

        /**
         * Change le statut des tranfers dont l'id est fourni dans $transfers_id.
         *
         * @param array $transfers_ids = Tableau des id des transfers voulus
         * @param mixed $progress
         *
         * @return int : Retourne le nombre de lignes mises à jour
         */
        public function updateProgressTransfersIn($transfers_ids, $progress)
        {
            $query = '
				UPDATE transfer
				SET progress = :progress
				WHERE id ';

            //On génère la clause IN et les paramètres adaptés depuis le tableau des id
            $generted_in = $this->_generate_in_from_array($transfers_ids);
            $query .= $generted_in['QUERY'];
            $params = $generted_in['PARAMS'];
            $params['progress'] = (bool) $progress;

            return $this->_run_query($query, $params, self::ROWCOUNT);
        }

        /**
         * Supprime tous les transfers dont l'id fait partie du tableau fourni.
         *
         * @param $transfers_ids : Tableau des id des transfers à supprimer
         *
         * @return int : Nombre de lignes supprimées
         */
        public function deleteTransfersIn($transfers_ids)
        {
            $query = '
				DELETE FROM transfer
				WHERE id ';

            //On génère la clause IN et les paramètres adaptés depuis le tableau des id
            $generted_in = $this->_generate_in_from_array($transfers_ids);
            $query .= $generted_in['QUERY'];
            $params = $generted_in['PARAMS'];

            return $this->_run_query($query, $params, self::ROWCOUNT);
        }

        //
        // PARTIE DES REQUETES EVENTS
        //

    }
