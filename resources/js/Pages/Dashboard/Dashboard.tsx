import AuthenticatedLayout from "@/Modules/Common/Layouts/AuthenticatedLayout/Authenticated";
import { Head } from "@inertiajs/react";
import { PageProps } from "@/Modules/Common/Types";
import { Box, Container, Paper, Stack, Text } from "@mantine/core";
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
