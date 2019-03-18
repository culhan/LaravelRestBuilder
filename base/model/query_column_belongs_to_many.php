                    \DB::raw("(
                        select concat('[',IFNULL(group_concat(CONCAT('{',
{{column_belongs_to_many}}                                
                        '}')),''),']') 
                        from {{belongs_to_many_intermediate_table}}
                        left join {{belongs_to_many_table}} on ({{belongs_to_many_table}}.id = {{belongs_to_many_intermediate_table}}.{{foreign_key_joining_model}})                            
                        -- start list belongs to many join option
                        -- end list belongs to many join option
                        where {{belongs_to_many_intermediate_table}}.{{foreign_key_model}} = {{table}}.id
                        -- start list belongs to many query option
                        -- end list belongs to many query option
                    ) as '{{belongs_to_many_name}}' "),