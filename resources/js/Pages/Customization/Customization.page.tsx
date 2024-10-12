import { Head } from "@inertiajs/react";
import { PageProps } from "@/types";
import { Divider, Stack } from "@mantine/core";
import { AdminLayout } from "@/Layouts/AdminLayout/AdminLayout";
import OfficeLogo from "./OfficeLogo";
import OrganizationDetails from "./OrganizationDetails";
import Themes from "./Themes";

export default function CustomizationPage({ auth }: PageProps) {
    return (
        <AdminLayout user={auth.user}>
            <Head title="Customization" />
            <Stack px={8} gap={48} py={8} mx={32} mt={32}>
                <OfficeLogo />

                <Divider c="dimmed" />

                <OrganizationDetails />

                <Divider c="dimmed" />

                <Themes />

                <Divider c="dimmed" />
            </Stack>
        </AdminLayout>
    );
}
