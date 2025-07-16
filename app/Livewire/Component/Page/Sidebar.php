<?php

namespace App\Livewire\Component\Page;

use App\Livewire\BaseComponent;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Sidebar extends BaseComponent
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
                    'name' => 'Site',
                    'url' => '/site',
                    'route' => 'site.index',
                    'icon' => 'bx bx-building-house',
                    'permission' => 'view:site'
                ],
                [
                    'name' => 'Machine',
                    'url' => '/machine',
                    'route' => 'machine.index',
                    'icon' => 'bx bx-fingerprint',
                    'permission' => 'view:machine',
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
                // [
                //     'name' => 'Project',
                //     'url' => '/project',
                //     'route' => 'project.index',
                //     'icon' => 'bx bx-briefcase-alt',
                //     'permission' => 'view:project'
                // ],
                [
                    'name' => 'Attendance',
                    'url' => '/attendance',
                    'route' => 'attendance.index',
                    'icon' => 'bx bx-purchase-tag-alt',
                    'permission' => 'view:attendance'
                ],
                [
                    'name' => 'Attendance Temporary',
                    'url' => '/attendance-temporary',
                    'route' => 'attendance-temporary.index',
                    'icon' => 'bx bxs-purchase-tag-alt',
                    'permission' => 'view:attendance-temp'
                ],
                [
                    'name' => 'Daily Report',
                    'icon' => 'bx bxs-report',
                    'url' => '/daily-report',
                    'permission' => 'view:daily-report',
                    'subMenus' => [
                        [
                            'name' => 'All Daily Report',
                            'url' => '/daily-report-all',
                            'route' => 'daily-report.index',
                            'icon' => 'bx bxs-report',
                            'permission' => 'view:daily-report-all'
                        ],
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
                [
                    'name' => 'Absent Request',
                    'icon' => 'bx bxs-tired',
                    'url' => '/absent-request',
                    'permission' => 'view:absent-request',
                    'subMenus' => [
                        [
                            'name' => 'All Absent Request',
                            'url' => '/absent-request-all',
                            'route' => 'absent-request.index',
                            'icon' => 'bx bxs-tired',
                            'permission' => 'view:absent-request-all',
                        ],
                        [
                            'name' => 'My Absent Request',
                            'url' => '/absent-request',
                            'route' => 'absent-request.index',
                            'icon' => 'bx bxs-tired',
                            'permission' => 'view:absent-request'
                        ],
                        [
                            'name' => 'Team Absent Request',
                            'url' => '/absent-request/team',
                            'route' => 'team-absent-request.index',
                            'icon' => 'bx bxs-tired',
                            'permission' => 'view:absent-request'
                        ],
                    ],
                ],
                [
                    'name' => 'Leave Request',
                    'url' => '/leave-request',
                    'icon' => 'bx bx-log-out-circle',
                    'permission' => 'view:leave-request',
                    'subMenus' => [
                        [
                            'name' => 'All Leave Request',
                            'url' => '/leave-request-all',
                            'route' => 'leave-request.all',
                            'icon' => 'bx bx-log-out-circle',
                            'permission' => 'view:leave-request-all',
                        ],
                        [
                            'name' => 'My Leave Request',
                            'url' => '/leave-request',
                            'route' => 'leave-request.index',
                            'icon' => 'bx bx-log-out-circle',
                            'permission' => 'view:leave-request'
                        ],
                        [
                            'name' => 'Team Leave Request',
                            'url' => '/leave-request/team',
                            'route' => 'team-leave-request.index',
                            'icon' => 'bx bx-log-out-circle',
                            'permission' => 'view:leave-request'
                        ],
                    ],
                ],
                [
                    'name' => 'Financial Request',
                    'url' => '/financial-request',
                    'icon' => 'bx bxs-bank',
                    'permission' => 'view:financial-request',
                    'subMenus' => [
                        [
                            'name' => 'All Financial Request',
                            'url' => '/financial-request-all',
                            'route' => 'financial-request.all',
                            'icon' => 'bx bxs-bank',
                            'permission' => 'view:financial-request-all'
                        ],
                        [
                            'name' => 'My Financial Request',
                            'url' => '/financial-request',
                            'route' => 'financial-request.index',
                            'icon' => 'bx bxs-bank',
                            'permission' => 'view:financial-request'
                        ],
                        [
                            'name' => 'Team Financial Request',
                            'url' => '/financial-request/team',
                            'route' => 'team-financial-request.index',
                            'icon' => 'bx bxs-bank',
                            'permission' => 'view:financial-request'
                        ],
                    ]
                ],
                [
                    'name' => 'Visit',
                    'url' => '/visit',
                    'route' => 'visit.index',
                    'icon' => 'bx bx-purchase-tag-alt',
                    'permission' => 'view:visit'
                ],
                [
                    'name' => 'Announcement',
                    'url' => '/announcement',
                    'route' => 'announcement.index',
                    'icon' => 'bx bx-bell',
                    'permission' => 'view:announcement'
                ],
            ]
        ],
        [
            'title' => 'Configuration',
            'menus' => [
                [
                    'name' => 'Setting',
                    'url' => '/setting',
                    'route' => 'setting.form',
                    'icon' => 'bx bx-cog',
                    'permission' => 'view:setting'
                ],
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
                [
                    'name' => 'Activity',
                    'url' => '/activity',
                    'route' => 'activity.index',
                    'icon' => 'bx bx-history',
                    'permission' => 'view:activity'
                ]
            ]
        ],
        [
            'title' => 'Report',
            'menus' => [
                [
                    'name' => 'Report Attendance',
                    'url' => '/report/attendance',
                    'route' => 'report.attendance',
                    'icon' => 'bx bx-bar-chart-alt-2',
                    'permission' => 'view:report-attendance'
                ],
                [
                    'name' => 'Report Absent',
                    'url' => '/report/absent-request',
                    'route' => 'report.absent-request',
                    'icon' => 'bx bx-bar-chart-alt-2',
                    'permission' => 'view:report-absent-request'
                ],
                [
                    'name' => 'Report Leave',
                    'url' => '/report/leave-request',
                    'route' => 'report.leave-request',
                    'icon' => 'bx bx-bar-chart-alt-2',
                    'permission' => 'view:report-leave-request'
                ],
                [
                    'name' => 'Report Financial',
                    'url' => '/report/financial-request',
                    'route' => 'report.financial-request',
                    'icon' => 'bx bx-bar-chart-alt-2',
                    'permission' => 'view:report-financial-request'
                ],
                [
                    'name' => 'Report Visit',
                    'url' => '/report/visit',
                    'route' => 'report.visit',
                    'icon' => 'bx bx-bar-chart-alt-2',
                    'permission' => 'view:report-visit'
                ],
            ]
        ],
    ];

    public function filterMenus()
    {
        $user = $this->authUser; // Mendapatkan user yang sedang login
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
