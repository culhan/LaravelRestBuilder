                    \DB::raw("(
                        select IFNULL(group_concat(CONCAT('{',                            
{{column_has_one}}
                        '}') {{custom_order}} ),'{}') 
                        from {{table_has_one}}
                        -- start list has one join option
                        -- end list has one join option
                        where {{table_has_one}}.{{column_has_one_foreign_key}} = {{table}}.{{column_has_one_relation_key}}
                        -- start list has one query option
                        -- end list has one query option
                    ) as '{{has_one_name}}' "),