import { Button, Flex, Modal, Text } from "@mantine/core";
import React, { FormEventHandler } from "react";
import { useForm } from "@inertiajs/react";
import { notifications } from "@mantine/notifications";
import { User } from "@/types";

interface IProps {
    isOpened: boolean;
    close: () => void;
    user?: User;
}

const DeleteUserForm: React.FC<IProps> = ({ isOpened, close, user }) => {
    const { processing, delete: destroy, reset } = useForm();

    const deleteMetadataSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        destroy(route("user.destroy", user?.id), {
            onSuccess: () => {
                close();
                notifications.show({
                    message: "User deleted successfully",
                    color: "red",
                });
            },
            onError: () => {
                close();
                notifications.show({
                    message: "Something went wrong",
                    color: "red",
                });
            },
            onFinish: () => reset(),
        });
    };

    return (
        <Modal
            opened={isOpened}
            onClose={close}
            title={<Text size="lg">Delete User</Text>}
            size={550}
        >
            <form onSubmit={deleteMetadataSubmit}>
                <Text c="dimmed" mt={4} size="sm">
                    Delete this user {user?.name}?
                </Text>

                <Flex align="center" justify="end" mt={16}>
                    <Button variant="subtle" color="gray" onClick={close}>
                        Cancel
                    </Button>

                    <Button ml={12} type="submit" loading={processing} color="red">
                        Confirm Delete
                    </Button>
                </Flex>
            </form>
        </Modal>
    );
};

export default DeleteUserForm;
