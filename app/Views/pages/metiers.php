<script type="text/javascript" src="https://code.jscharting.com/latest/jscharting.js"></script>
<script type="text/javascript" src="https://code.jscharting.com/latest/modules/types.js"></script>
<style>
    .tooltip-container {
        background-color: #0E341CBB;
        color: white;
        border-radius: 4px;
        padding: 0.5rem;
    }

    .tooltip-content {
        font-size: 2.25rem;
        width: 400px;
    }

    .tooltip-content small {
        font-size: 1rem;
    }
</style>
<div id="ck_organigramme" style="width: 100%; height: 100%; margin: 0rem auto;"></div>
<script>
    let php_var;
    if (php_var = <?php echo json_encode($jobs_tree); ?>) {
        const unformattedData = php_var
        delete php_var
        console.log(unformattedData)

        const CHIEF_ID = "Commandant"
        const ROLE_OFFICER_CONFIG = (label, officer, members) => ({
            id: label,
            name: officer ? officer.name : 'Poste de chef à pourvoir',
            label_text: `<span style="font-size:36px; text-transform: uppercase; ">%role</span><br><img width=64 height=64 margin_bottom=4 src=%image><br><span style="font-size:32px;">%name</span><br><span style="font-size:16px;">${officer ? officer.primary_group : 'Lancez vous !'}</span>`,
            annotation: {margin: 100, width: 450},
            tooltip: `<div class="tooltip-container">
                        ${members.map(({username, primary_group}) =>
                            `<p class="tooltip-content">${username} <small>(${primary_group})</small></p>`).join('') || '<p class="tooltip-content">Postes à pourvoir</p>'}
                    </div>`,
            attributes: {
                role: label,
                image: officer ?
                    `pictures/jackets/${officer.primary_group}.png` :
                    'pictures/logo_ck_website.png'
            },
        })

        const chief = unformattedData.primary[0].members[0]

        const data2 = unformattedData
            .secondary
            .map(({label, officer, members}) => [
                {
                    ...ROLE_OFFICER_CONFIG(label, officer, members),
                    //parent: members.map(({id}) => `${label}_${id}`).toString(),
                }
            ])
            .flat()

        const data3 = unformattedData
            .tertiary
            .map(({label, officer, members}) => [
                {
                    ...ROLE_OFFICER_CONFIG(label, officer, members),
                    parent: CHIEF_ID,
                }
            ])
            .flat()


        const chart = JSC.Chart("ck_organigramme", {
            debug: true,
            type: 'organizational',
            defaultTooltip: {
                asHTML: true,
                outline: 'none',
                zIndex: 10
            }, 
            defaultAnnotation: { margin: 10, width: 150 },
            defaultSeries: {
                color: '#0E341C',
                defaultPoint: {
                    outline_width: 0,
                    connectorLine: {
                        radius: 5,
                        width: 2,
                        color: '#BDBDBD'
                    },
                    label_text:
                        '<img width=64 height=64 margin_bottom=4 src=%image><br><span style="font-size:16px">%name</span>'
                }
            },
            series: [
                {
                    points: [
                        ...data2,
                        ...data3,
                        {
                            name: chief.username,
                            id: CHIEF_ID,
                            label_text:
                                '<span style="font-size:64px;">%role</span><br><span style="font-size:48px;">%name</span>',
                            annotation: {width: 600},
                            parent: unformattedData.secondary.map(({label}) => label).toString(),
                            attributes: {
                                role: 'Commandant',
                                image: `pictures/jackets/${chief.primary_group}.png`
                            } 
                        }
                    ]
                }
            ]
        })
    }
</script>