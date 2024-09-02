<?php

namespace App\Livewire\Component\Page;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Sidebar extends Component
{
    public $menuUsers = [];
    protected $menus = [
        [
            'title' => 'Dashboard',
            'menus' => [
                [
                    'name' => 'Dashboard',
                    'url' => '/dashboard',
                    'route' => 'dashboard.index',
                    'icon' => 'bx bx-home-circle',
                    'permission' => 'view:dashboard'
                ],
            ]
        ],
        [
            'title' => 'Master Data',
            'menus' => [
                [
                    'name' => 'Import Master Data',
                    'url' => '/import-master-data',
                    'route' => 'import.index',
                    'icon' => 'bx bx-upload',
                    'permission' => 'view:import_master_data',
                ],
                [
                    'name' => 'Machine',
                    'url' => '/machine',
                    'route' => 'machine.index',
                    'icon' => 'bx bx-fingerprint',
                    'permission' => 'view:machine',
                ],
                [
                    'name' => 'Site',
                    'url' => '/site',
                    'route' => 'site.index',
                    'icon' => 'bx bx-building-house',
                    'permission' => 'view:site'
                ],
                [
                    'name' => 'Department',
                    'url' => '/department',
                    'route' => 'department.index',
                    'icon' => 'bx bxl-codepen',
                    'permission' => 'view:department'
                ],
                [
                    'name' => 'Position',
                    'url' => '/position',
                    'route' => 'position.index',
                    'icon' => 'bx bx-briefcase-alt-2',
                    'permission' => 'view:position'
                ],
                [
                    'name' => 'Role',
                    'url' => '/role',
                    'route' => 'role.index',
                    'icon' => 'bx bxs-key',
                    'permission' => 'view:role'
                ],
                // [
                //     'name' => 'User',
                //     'url' => '/user',
                //     'route' => 'user.index',
                //     'icon' => 'bx bx-user-circle',
                //     'permission' => 'view:user'
                // ],
                [
                    'name' => 'Employee',
                    'url' => '/employee',
                    'route' => 'employee.index',
                    'icon' => 'bx bxs-user-circle',
                    'permission' => 'view:employee'
                ],

            ]
        ],
        [
            'title' => 'Application',
            'menus' => [
                [
                    'name' => 'Project',
                    'url' => '/project',
                    'route' => 'project.index',
                    'icon' => 'bx bx-briefcase-alt',
                    'permission' => 'view:project'
                ],
                [
                    'name' => 'Attendance',
                    'url' => '/attendance',
                    'route' => 'attendance.index',
                    'icon' => 'bx bx-purchase-tag-alt',
                    'permission' => 'view:attendance'
                ],
                // [
                //     'name' => 'Attendance Temporary',
                //     'url' => '/attendance-temporary',
                //     'route' => 'attendance-temporary.index',
                //     'icon' => 'bx bxs-purchase-tag-alt',
                //     'permission' => 'view:attendance-temp'
                // ],
                [
                    'name' => 'Daily Report All',
                    'url' => '/daily-report-all',
                    'route' => 'daily-report.index',
                    'icon' => 'bx bxs-report',
                    'permission' => 'view:daily-report-all'
                ],
                [
                    'name' => 'Daily Report',
                    'icon' => 'bx bxs-report',
                    'url' => '/daily-report',
                    'permission' => 'view:daily-report',
                    'subMenus' => [
                        [
                            'name' => 'My Daily Report',
                            'url' => '/daily-report',
                            'route' => 'daily-report.index',
                            'icon' => 'bx bxs-report',
                            'permission' => 'view:daily-report'
                        ],
                        [
                            'name' => 'Team Daily Report ',
                            'url' => '/daily-report/team',
                            'route' => 'team-daily-report.index',
                            'icon' => 'bx bxs-report',
                            'permission' => 'view:daily-report'
                        ],
                    ],
                ],
                // [
                //     'name' => 'Absence Request',
                //     'url' => '/absence-request',
                //     'route' => 'absence-request.index',
                //     'icon' => 'bx bxs-tired',
                //     'permission' => 'view:absence-request-all',
                // ],
                // [
                //     'name' => 'Absence Request',
                //     'icon' => 'bx bxs-tired',
                //     'url' => '/absence-request',
                //     'permission' => 'view:absence-request',
                //     'subMenus' => [
                //         [
                //             'name' => 'My Absence Request',
                //             'url' => '/absence-request',
                //             'route' => 'absence-request.index',
                //             'icon' => 'bx bxs-tired',
                //             'permission' => 'view:absence-request'
                //         ],
                //         [
                //             'name' => 'Team Absence Request',
                //             'url' => '/absence-request/team',
                //             'route' => 'team-absence-request.index',
                //             'icon' => 'bx bxs-tired',
                //             'permission' => 'view:absence-request'
                //         ],
                //     ],
                // ],
                // [
                //     'name' => 'Leave Request',
                //     'url' => '/leave-request',
                //     'route' => 'leave-request.index',
                //     'icon' => 'bx bx-log-out-circle',
                //     'permission' => 'view:leave-request-all',
                // ],
                // [
                //     'name' => 'Leave Request',
                //     'url' => '/leave-request',
                //     'icon' => 'bx bx-log-out-circle',
                //     'permission' => 'view:leave-request',
                //     'subMenus' => [
                //         [
                //             'name' => 'My Leave Request',
                //             'url' => '/leave-request',
                //             'route' => 'leave-request.index',
                //             'icon' => 'bx bx-log-out-circle',
                //             'permission' => 'view:leave-request'
                //         ],
                //         [
                //             'name' => 'Team Leave Request',
                //             'url' => '/leave-request/team',
                //             'route' => 'team-leave-request.index',
                //             'icon' => 'bx bx-log-out-circle',
                //             'permission' => 'view:leave-request'
                //         ],
                //     ],
                // ],
                // [
                //     'name' => 'Financial Request',
                //     'url' => '/financial-request',
                //     'route' => 'financial-request.index',
                //     'icon' => 'bx bxs-bank',
                //     'permission' => 'view:financial-request-all'
                // ],
                // [
                //     'name' => 'Financial Request',
                //     'url' => '/financial-request',
                //     'icon' => 'bx bxs-bank',
                //     'permission' => 'view:financial-request',
                //     'subMenus' => [
                //         [
                //             'name' => 'My Financial Request',
                //             'url' => '/financial-request',
                //             'route' => 'financial-request.index',
                //             'icon' => 'bx bxs-bank',
                //             'permission' => 'view:financial-request'
                //         ],
                //         [
                //             'name' => 'Team Financial Request',
                //             'url' => '/financial-request/team',
                //             'route' => 'team-financial-request.index',
                //             'icon' => 'bx bxs-bank',
                //             'permission' => 'view:financial-request'
                //         ],
                //     ]
                // ]
            ]
        ],
        [
            'title' => 'Other',
            'menus' => [
                [
                    'name' => 'Email Template',
                    'url' => '/email-template',
                    'route' => 'email-template.index',
                    'icon' => 'bx bx-code-curly',
                    'permission' => 'view:email-template'
                ],
            ]
        ],
        // [
        //     'title' => 'Report',
        //     'menus' => [
        //         [
        //             'name' => 'Report Attendance',
        //             'url' => '/report-attendance',
        //             'route' => 'report-attendance.index',
        //             'icon' => 'bx bx-bar-chart-alt-2',
        //             'permission' => 'view:report-attendance'
        //         ],
        //         [
        //             'name' => 'Report Absence',
        //             'url' => '/report-absence-request',
        //             'route' => 'report-absence-request.index',
        //             'icon' => 'bx bx-bar-chart-alt-2',
        //             'permission' => 'view:report-absence-request'
        //         ],
        //         [
        //             'name' => 'Report Leave',
        //             'url' => '/report-leave-request',
        //             'route' => 'report-leave-request.index',
        //             'icon' => 'bx bx-bar-chart-alt-2',
        //             'permission' => 'view:report-leave-request'
        //         ],
        //         [
        //             'name' => 'Report Financial',
        //             'url' => '/report-financial-request',
        //             'route' => 'report-financial-request.index',
        //             'icon' => 'bx bx-bar-chart-alt-2',
        //             'permission' => 'view:report-financial-request'
        //         ],
        //         [
        //             'name' => 'Report Visit',
        //             'url' => '/report-visit-request',
        //             'route' => 'report-visit-request.index',
        //             'icon' => 'bx bx-bar-chart-alt-2',
        //             'permission' => 'view:report-visit'
        //         ],
        //     ]
        // ],
        // [
        //     'title' => 'Setting',
        //     'menus' => [
        //         [
        //             'name' => 'Setting',
        //             'url' => '/setting',
        //             'route' => 'setting.index',
        //             'icon' => 'bx bx-cog',
        //             'permission' => 'view:setting'
        //         ],
        //     ]
        // ],
    ];

    public function filterMenus()
    {
        $user = Auth::user(); // Mendapatkan user yang sedang login
        $this->menuUsers = [];

        foreach ($this->menus as $menu) {
            $filteredMenus = [];

            foreach ($menu['menus'] as $subMenu) {
                $hasPermission = $user->hasPermissionTo($subMenu['permission']);

                if (isset($subMenu['subMenus'])) {
                    $filteredSubMenus = [];
                    foreach ($subMenu['subMenus'] as $subSubMenu) {
                        if ($user->hasPermissionTo($subSubMenu['permission'])) {
                            $filteredSubMenus[] = [
                                'name' => $subSubMenu['name'],
                                'url' => $subSubMenu['url'],
                                'route' => $subSubMenu['route'],
                                'icon' => $subSubMenu['icon'],
                                'permission' => $subSubMenu['permission']
                            ];
                        }
                    }
                    if (!empty($filteredSubMenus)) {
                        $filteredMenus[] = [
                            'name' => $subMenu['name'],
                            'icon' => $subMenu['icon'],
                            'permission' => $subMenu['permission'],
                            'subMenus' => $filteredSubMenus
                        ];
                    }
                } elseif ($hasPermission) {
                    $filteredMenus[] = [
                        'name' => $subMenu['name'],
                        'url' => $subMenu['url'],
                        'route' => $subMenu['route'],
                        'icon' => $subMenu['icon'],
                        'permission' => $subMenu['permission']
                    ];
                }
            }

            if (!empty($filteredMenus)) {
                $this->menuUsers[] = ['title' => $menu['title'], 'menus' => $filteredMenus];
            }
        }
    }

    public function mount()
    {
        $this->filterMenus();
    }

    public function render()
    {
        return view('livewire.component.page.sidebar');
    }
}
