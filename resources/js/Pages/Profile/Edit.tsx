import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import DeleteUserForm from "./Partials/DeleteUserForm";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm";
import { Head } from "@inertiajs/react";
import { PageProps } from "@/types";
import { Paper, Text } from "@mantine/core";
import classes from "./Edit.module.css";

export default function Edit({
    auth,
    mustVerifyEmail,
    status,
}: PageProps<{ mustVerifyEmail: boolean; status?: string }>) {
    return (
        <AuthenticatedLayout user={auth.user} header="Profile">
            <Head title="Profile" />

            <div className={classes.container}>
                <Paper shadow="xs" radius="md" className={classes.card}>
                    <UpdateProfileInformationForm
                        mustVerifyEmail={mustVerifyEmail}
                        status={status}
                    />
                </Paper>
                <Paper shadow="xs" radius="md" className={classes.card}>
                    <UpdatePasswordForm />
                </Paper>

                <Paper shadow="xs" radius="md" className={classes.card}>
                    <DeleteUserForm />
                </Paper>
            </div>
        </AuthenticatedLayout>
    );
}
