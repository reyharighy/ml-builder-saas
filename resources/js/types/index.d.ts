import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
}

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    name: string;
    appUrl: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
};

export interface User {
    id: string;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;

    // Children
    datasets?: Dataset[];
    projects?: Project[];
}

export interface Dataset {
    id: string;
    user_id: string;
    name: string;
    description: string;
    filename: string;
    created_at: string;
    updated_at: string;

    // Parent
    user: User;
}

export interface Project {
    id: string;
    user_id: string;
    name: string;
    description: string;
    created_at: string;
    updated_at: string;

    // Parent
    user: User;
}
