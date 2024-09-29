import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import { PageProps } from "@/types";
import { Box, Container, Paper, Stack, Text } from "@mantine/core";
import WorkspaceForm from "@/Modules/Workspace/Forms/WorkspaceForm";
import FolderForm from "@/Modules/Folder/Forms/FolderForm";
import DocumentForm from "@/Modules/Document/Forms/DocumentForm";
import ApiTester from "./ApiTester";

export default function Dashboard({ auth }: PageProps) {
    return (
        <AuthenticatedLayout user={auth.user} header="Dashboard">
            <Head title="Dashboard" />

            <Box py={48}>
                <Container size={1280} px={32}>

                    <Paper p={32} shadow="xs">
                        {/* <Text>
                            Your Logged In!
                        </Text> */}

                        <ApiTester />
                    </Paper>

                </Container>
            </Box>
        </AuthenticatedLayout>
    );
}
