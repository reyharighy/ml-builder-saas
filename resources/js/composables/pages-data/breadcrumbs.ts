import { BreadcrumbItem } from "@/types";

export const breadcrumbsData: Record<string, BreadcrumbItem[]> = {
    'dashboard': [
        {
            title: 'Dashboard',
            href: route('dashboard'),
        },
    ],
    'datasets.index': [
        {
            title: 'Datasets',
            href: route('datasets.index'),
        },
    ],
    'projects.index': [
        {
            title: 'Project Hub',
            href: route('projects.index'),
        },
    ],
    'profile.edit': [
        {
            title: 'Profile settings',
            href: route('profile.edit'),
        },
    ],
    'password.edit': [
        {
            title: 'Password settings',
            href: route('password.edit'),
        },
    ],
    'appearance': [
        {
            title: 'Appearance settings',
            href: route('appearance'),
        },
    ]
};
