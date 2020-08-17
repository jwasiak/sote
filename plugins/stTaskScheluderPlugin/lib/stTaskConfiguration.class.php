<?php

/**
 * Konfiguracja harmonogramu zadań
 * @author Marcin Butlak <marcin.butlak@sote.pl>
 */
class stTaskConfiguration
{
    const TIME_INTERVAL_5MIN = 300;
    const TIME_INTERVAL_10MIN = self::TIME_INTERVAL_5MIN * 2;
    const TIME_INTERVAL_15MIN = self::TIME_INTERVAL_5MIN * 3;
    const TIME_INTERVAL_30MIN = self::TIME_INTERVAL_15MIN * 2;
    const TIME_INTERVAL_1HOUR = self::TIME_INTERVAL_30MIN * 2;
    const TIME_INTERVAL_2HOURS = self::TIME_INTERVAL_1HOUR * 2;
    const TIME_INTERVAL_4HOURS = self::TIME_INTERVAL_1HOUR * 4;
    const TIME_INTERVAL_6HOURS = self::TIME_INTERVAL_1HOUR * 6;
    const TIME_INTERVAL_12HOURS = self::TIME_INTERVAL_1HOUR * 12;
    const TIME_INTERVAL_1DAY = self::TIME_INTERVAL_1HOUR * 24;
    const TIME_INTERVAL_1WEEK = self::TIME_INTERVAL_1DAY * 7;

    const PRIORITY_FIRST = -1000000;
    const PRIORITY_LAST = 1000000;

    /**
     * Dodaje nowe zadanie
     *
     * @param string $id Id zadania
     * @param string $className Klasa zadania
     * @param string $name Nazwa zadania (wyświetlana użytkownikowi)
     * @param integer $interval Interwał czasowy
     * @param string $executeAt Godzina o której ma zostać wykonane zadanie (parametr jest brany pod uwagę tylko w przypadku interwału czasowego: TIME_INTERVAL_1DAY, TIME_INTERVAL_1WEEK)
     * @param bool $isSystem Zadanie systemowe
     * @return void
     */
    public static function addTask(string $id, string $className, string $name, array $options = array()): void
    {
        if (strlen($id) > 64)
        {
            throw new stTaskConfigurationException('The task id cannot exceed 64 characters');
        }

        if (!class_exists($className))
        {
            throw new stTaskConfigurationException(sprintf('The class name "%s" does not exist', $className));
        }

        $defaults = array(
            'time_interval' => self::TIME_INTERVAL_1HOUR,
            'execute_at' => '23:59:59',
            'is_system' => false,
            'priority' => 0,
            'is_active' => true,
        );

        if ($options)
        {
            $diff = array_diff_key($options, $defaults);

            if (!empty($diff))
            {
                throw new stTaskConfigurationException(sprintf('The options "%s" do not exist. Available options are "%s"', implode(", ", array_keys($diff)), implode(", ", array_keys($defaults))));
            }
        }

        $tasks = sfConfig::get('app_st_task_scheluder_tasks', array());

        $options['class_name'] = $className;
        $options['name'] = $name;

        $tasks[$id] = array_merge($defaults, $options);

        sfConfig::set('app_st_task_scheluder_tasks', $tasks);
    }

    /**
     * Zwraca listę konfiguracji zadań
     *
     * @return array
     */
    public static function getTasks(): array
    {
        $tasks = sfConfig::get('app_st_task_scheluder_tasks', array());

        uasort($tasks, function($t1, $t2) {
            if ($t1['priority'] == $t2['priority']) {
                return 0;
            }

            return ($t1['priority'] < $t2['priority']) ? -1 : 1;
        });

        return $tasks;
    }

    /**
     * Zwraca konfiguracje dla zadania
     *
     * @param string $taskId
     * @return array
     */
    public static function getTask(string $taskId)
    {
        $tasks = self::getTasks();

        if (!isset($tasks[$taskId]))
        {
            throw new stTaskConfigurationException(sprintf('The task with id "%s" does not exist', $taskId));
        }

        return $tasks[$taskId];
    }
}