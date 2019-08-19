                    \DB::raw("(
                        select concat('[',IFNULL(group_concat(CONCAT('{',                            
{{column_has_many}}
                        '}') {{custom_order}} ),''),']') 
                        from {{table_has_many}}
                        -- start list has many join option
                        -- end list has many join option
                        where {{table_has_many}}.{{column_has_many_foreign_key}} = {{table}}.{{column_has_many_relation_key}}
                        -- start list has many query option
                        -- end list has many query option
                    ) as '{{has_many_name}}' "),