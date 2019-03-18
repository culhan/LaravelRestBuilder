                    \DB::raw("(
                        select IFNULL(group_concat(CONCAT('{',                            
{{column_belongs_to}}
                        '}') ),'[]')
                        from {{table_belongs_to}}
                        -- start list belongs to join option
                        -- end list belongs to join option
                        where {{table_belongs_to}}.id = {{table}}.{{column_belongs_to_foreign_key}}
                        -- start list belongs to query option
                        -- end list belongs to query option
                    ) as '{{belongs_to_name}}' "),